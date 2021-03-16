<?php
include_once "Database.php";
include_once "Validator.php";
include_once "Reservation.php";
class Helper{
    function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getInstance();
        $this->validate = new Validator();
        $this->reservation = new Reservation();
    }
    function adminExistance(){
        $qy = $this->conn->prepare("SELECT * FROM administrators");
        $qy->execute();
        if($qy->rowCount()==0){
            $qy = $this->conn->prepare("INSERT INTO administrators SET firstname=:fname,lastname=:lname,email=:email,phone=:phone,password=:pwd");
            $qy->execute(['fname'=>'Gad','lname'=>'Ishimwe','email'=>'gad@gmail.com','phone'=>'0726183050','pwd'=>base64_encode(12345)]);
            if($qy->rowCount() ==0){
                echo json_encode($qy->errorInfo());
                exit;
            }
        }
    }
    public function login($datas){
//        return $datas;
        $this->reservation->cancelExpiredReservation();
        $this->adminExistance();

        $response = ['status'=>'ok','data'=>[],'message'=>"<div class='alert alert-success'>Successful logged in</div>"];
        //validation
        if(!$this->validate->email($datas['email']) || !$this->validate->phone("rwandan",$datas['email'])){
            return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>Invalid email address or phone number</div>"];
        }

        $qy = $this->conn->prepare("SELECT * FROM administrators WHERE (phone=:phone OR email=:phone) AND password=:pwd");
        $qy->execute(['phone'=>$datas['email'],'pwd'=>base64_encode($datas['password'])]);
        if($qy->rowCount()==1){//success
            $response['user_info'] = $qy->fetchAll(PDO::FETCH_ASSOC)[0];
            $response['user_info']['role'] = "Admin";
        }else {
            $qy = $this->conn->prepare("SELECT * FROM employee WHERE (phone=:phone OR email=:phone) AND password=:pwd");
            $qy->execute(['phone' => $datas['email'], 'pwd' => base64_encode($datas['password'])]);
            if ($qy->rowCount() == 1) {//Validatorsuccess
                $response['user_info'] = $qy->fetchAll(PDO::FETCH_ASSOC)[0];
                $response['user_info']['role'] = 'Teacher';
            } else {//check student
                $qyResident = $this->conn->prepare("SELECT * FROM student WHERE (reg_number=:phone OR phone=:phone OR email=:phone) AND password=:pwd");
                $qyResident->execute(['phone' => $datas['email'], 'pwd' => base64_encode($datas['password'])]);
//                return [$qyResident->rowCount()];
                if ($qyResident->rowCount() == 1) {//success
                    $response['user_info'] = $qyResident->fetchAll(PDO::FETCH_ASSOC)[0];
                    $response['user_info']['role'] = 'Student';
                } else {//check stock manager
                    $qyResident = $this->conn->prepare("SELECT * FROM stock_manager WHERE (phone=:phone OR email=:phone) AND password=:pwd");
                    $qyResident->execute(['phone' => $datas['email'], 'pwd' => base64_encode($datas['password'])]);
                    if ($qyResident->rowCount() == 1) {//success
                        $response['user_info'] = $qyResident->fetchAll(PDO::FETCH_ASSOC)[0];
                        $response['user_info']['role'] = 'StockManager';
                    } else {//check lab technician
                        $qyResident = $this->conn->prepare("SELECT * FROM lab_technician WHERE (phone=:phone OR email=:phone) AND password=:pwd");
                        $qyResident->execute(['phone' => $datas['email'], 'pwd' => base64_encode($datas['password'])]);
                        if ($qyResident->rowCount() == 1) {//success
                            $response['user_info'] = $qyResident->fetchAll(PDO::FETCH_ASSOC)[0];
                            $response['user_info']['role'] = 'LabTechnician';
                        } else {
                            $response['status'] = 'fail';
                            $response['message'] = "<div class='alert alert-danger'>Wrong credential provided ".json_encode($qyResident->rowCount())." </div>";
                        }
                    }
                }
            }
        }
        return $response;
    }
}
?>