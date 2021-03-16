<?php
include_once "Database.php";

class Reservation
{
    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
        $this->reservation_time = "10";//in minute
    }

    function save($datas)
    {
        $feed = ['status' => 'ok', "message" => "<div class='alert alert-success'>Asset successfully reserved for an hour</div>"];
        $employee_id = 0;
        $student_id = 0;
        $role = $datas['role'];
        if($role=='Teacher')
            $employee_id = $datas['user_id'];
        elseif($role=='Student')
            $student_id = $datas['user_id'];

        if($student_id==0 && $employee_id==0) return ['status'=>0,"message"=>"<div class='alert alert-danger'>Cant find Student or teacher</div>"];

        $qy = $this->conn->prepare("SELECT * FROM reservation WHERE asset_id=:assetid OR asset_id IN (SELECT asset_id FROM asset_movement WHERE  asset_movement.asset_id=:assetid AND asset_movement.submitted_on IS NULL)");
        $qy->execute(['assetid' => $datas['asset_id']]);
        if ($qy->rowCount() == 0) {
            $qy = $this->conn->prepare("INSERT INTO reservation SET asset_id=:assetid,student_id=:studentid,employee_id=:employee,location=:location,quantity=:quantity");
            $qy->execute(['assetid' => $datas['asset_id'], 'studentid' => $student_id, 'employee' => $employee_id, 'quantity' => $datas['quantity'], 'location' => $datas['location']]);
            if($qy->rowCount()==0) return ['status'=>'fail','message'=>"<div class='alert alert-danger'>Something went wrong,cant record reservation ".json_encode($qy->errorInfo())."</div>"];
        } else {
            $feed = ['status' => 'ok', "message" => "<div class='alert alert-info'>Asset not available for reservation</div>"];
        }
        return $feed;
    }
    function get($datas){

        $qy=$this->conn->prepare("SELECT am.*,a.names,a.serial_number,a.code,a.type,a.state,CASE WHEN am.student_id!=0 THEN CONCAT(s.firstname,' ',s.lastname) ELSE CONCAT(e.firstname,' ',e.lastname) END AS lend_to,CONCAT(e.firstname,' ',e.lastname) as given_by FROM reservation am INNER JOIN assets a ON a.id=am.asset_id LEFT JOIN student s ON s.id=am.student_id LEFT JOIN employee e ON e.id=am.employee_id");
        $qy->execute();
        return $qy->fetchAll(PDO::FETCH_ASSOC);
    }
    function getUserReservation($datas){
        $additionalWhere = "";
        if($datas['role'] == 'Teacher'){
            $additionalWhere .= "WHERE am.employee_id='".$datas['user_id']."'";
        }else $additionalWhere .= "WHERE am.student_id='".$datas['user_id']."'";

        $qy = $this->conn->prepare("SELECT am.*,a.names,a.serial_number,a.code,a.type,a.state,CASE WHEN am.student_id!=0 THEN CONCAT(s.firstname,' ',s.lastname) ELSE CONCAT(e.firstname,' ',e.lastname) END AS lend_to,CONCAT(e.firstname,' ',e.lastname) as given_by FROM reservation am INNER JOIN assets a ON a.id=am.asset_id LEFT JOIN student s ON s.id=am.student_id LEFT JOIN employee e ON e.id=am.employee_id ".$additionalWhere);
        $qy->execute();
//        return $qy->errorInfo();
        return $qy->fetchAll(PDO::FETCH_ASSOC);
    }
    function getById($datas){
        $qy=$this->conn->prepare("SELECT r.*,CONCAT(s.firstname,s.lastname) as student_name,CONCAT(e.firstname,e.lastname) as teacher_name FROM reservation r LEFT JOIN student s ON s.id=r.student_id INNER JOIN assets a ON a.id=r.asset_id LEFT JOIN employee e ON e.id=r.employee_id WHERE r.id=:id");
        $qy->execute(['id'=>$datas['id']]);
        return $qy->fetchAll(PDO::FETCH_ASSOC);
    }

    function delete($datas){
        $feed = ['status' => 'ok', "message" => "<div class='alert alert-success'>Your aSSET reservation cancelled successfully</div>"];
        $qy=$this->conn->prepare("DELETE FROM reservation where id=:id AND StudentId=:student");
        $qy->execute(['id'=>$datas['id'],'student'=>$datas['studentid']]);

        if($qy->rowCount()==0){
            $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>Failed to cancel your reservation</div>"];
        }
        return $feed;
    }
    function taken($datas){
        $feed = ['status' => 'ok', "message" => "<div class='alert alert-success'>Reserved book taken successful</div>"];
        $qy0=$this->conn->prepare("SELECT * FROM reservation where id=:id");
        $qy0->execute(['id'=>$datas['id']]);

        if($qy0->rowCount()!=0){
            $reservationInfo = $qy0->fetch(PDO::FETCH_ASSOC);
//            return $reservationInfo;
            //issue book
            $qy1=$this->conn->prepare("INSERT INTO asset_movement SET student_id=:studentid,employee_id=:employeeid,asset_id=:assetid,given_on=:givenon,quantity=:quantity,location=:location,done_by=:doneby");
            $qy1->execute(['studentid'=>$reservationInfo['student_id'],'employeeid'=>$reservationInfo['employee_id'],'assetid'=>$reservationInfo['asset_id'],'givenon'=>date("Y-m-d H:i"),'doneby'=>$datas['doneby'],"quantity"=>$reservationInfo['quantity'],"location"=>$reservationInfo['location']]);
            if($qy1->rowCount()>0){
                //delete from reservation
                $qy2=$this->conn->prepare("DELETE FROM reservation where id=:id");
                $qy2->execute(['id'=>$datas['id']]);
            }
        }else {
            $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>Can't find reservation</div>"];
        }
        return $feed;
    }
    function expiredReservation(){
        $qy = $this->conn->prepare("SELECT reservation.created_at,DATE_ADD(created_at,INTERVAL :expire_time MINUTE) AS expire_at FROM reservation WHERE DATE_ADD(created_at,INTERVAL :expire_time MINUTE)<CURRENT_TIMESTAMP");
        $qy->execute(['expire_time'=>$this->reservation_time]);
        return $qy->fetchAll(PDO::FETCH_ASSOC);
    }
    public function cancelExpiredReservation(){
        $qy = $this->conn->prepare("DELETE FROM reservation WHERE DATE_ADD(created_at,INTERVAL :expire_time MINUTE)<CURRENT_TIMESTAMP AND id!=0");
        $qy->execute(['expire_time'=>$this->reservation_time]);
    }

}

?>