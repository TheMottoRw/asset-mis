<?php
include_once "Database.php";

class AssetMovement
{

    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
    }

    function insertAssetMovement($arr)
    {
        $student_id = 0;
        $employee_id = 0;
        $error = "";
        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Asset given successful</div>", 'id' => 0];

        $borrowerEmail = $arr['student_id'];
        $asset_id = $arr['asset_id'];
        $booked_on = $arr['booked_on'];
        $location = $arr['location'];
        $status = "given";
        $quantity = $arr['quantity'];
        $doneby = $arr['user_id'];

        $qy = $this->conn->prepare("SELECT * FROM employee where email=:email");
        $qy->execute(['email'=>$borrowerEmail]);
        if($qy->rowCount()>0){
            $employee_id = $qy->fetchAll(PDO::FETCH_ASSOC)[0]['id'];
        }
        $qy0 = $this->conn->prepare("SELECT * FROM student WHERE reg_number=:email");
        $qy0->execute(['email'=>$borrowerEmail]);
        if($qy0->rowCount()>0){
            $student_id = $qy0->fetchAll(PDO::FETCH_ASSOC)[0]['id'];
        }
        if($employee_id==0 && $student_id==0) return ['status'=>'ok',"message"=>"<div class='alert alert-danger'>Cant find student or teacher to give an asset</div>"];
        else{
            $qy1 = $this->conn->prepare("INSERT INTO asset_movement SET student_id=:studentid,employee_id=:empid,asset_id=:assetid,given_on=:givenon,location=:location,quantity=:quantity,done_by=:doneby");
            $qy1->execute(['studentid'=>$student_id,'empid'=>$employee_id,'assetid'=>$asset_id,'givenon'=>$booked_on,'location'=>$location,'quantity'=>$quantity,'doneby'=>$doneby]);
            if($qy1->rowCount()==0) {
                return ['status' => 'fail','message'=>"<div class='alert alert-danger'>Something went wrong,can't give an asset ".json_encode($qy1->errorInfo())."</div>"];
            }
        }
        return $response;
    }
    function bookAsset($arr){
        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Asset successfully booked</div>", 'id' => 0];

        $student_id = $arr['student_id'];
        $asset_id = $arr['asset_id'];
        $booked_on = $arr['booked_on'];
        $submitted_on = $arr['submitted_on'];
        $location = $arr['location'];
        $status = $arr['status'];
        $quantity = $arr['quantity'];

        $query = $this->conn->prepare("INSERT INTO asset_movement set student_id =:student_id,asset_id=:asset_id,booked_on=:booked_on,submitted_on=:submitted_on,location=:location,status=:status,quantity=:quantity");
        $query->execute(array("student_id" => $student_id, "asset_id" => $asset_id, "booked_on" => $booked_on, "submitted_on" => $submitted_on, "location" => $location, "status" => $status, "quantity" => $quantity));
        if ($query->rowCount() > 0) {
            $response ['message'] = "student added";
            $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "failed to add student", 'error' => $query->errorInfo()];
        }
        return $response;
    }
    function getAllAssetMovements()
    {
        $query = $this->conn->query("SELECT am.*,a.names,a.serial_number,a.code,a.type,a.state,CASE WHEN am.student_id!=0 THEN CONCAT(s.firstname,' ',s.lastname) ELSE CONCAT(e.firstname,' ',e.lastname) END AS lend_to,CONCAT(lt.firstname,' ',lt.lastname) as given_by FROM asset_movement am INNER JOIN assets a ON a.id=am.asset_id LEFT JOIN student s ON s.id=am.student_id LEFT JOIN employee e ON e.id=am.employee_id LEFT JOIN lab_technician lt ON am.done_by=lt.id");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getAssetMovementById($id)
    {
        $query = $this->conn->prepare("SELECT * FROM asset_movement where id=:id");
        $query->execute(array("id" => $id));
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
        if ($query->rowCount() == 0) {
            return [];
        }
        return $data;
    }

    function deleteAssetMovement($id)
    {
        $response = ['status' => 'ok', 'message' => "succesful fetched", 'id' => $id];

        $query = $this->conn->prepare("DELETE FROM asset_movement WHERE id=:id");
        $query->execute(array("id" => $id));

        if ($query->rowCount() == 0) {
            $response = ['status' => 'fail', 'message' => "Failed to delete", 'id' => $id, "error" => $query->errorInfo()];
        }
        return $response;
    }

    function updateAssetMovement($arr)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Asset updated successful</div>", 'id' => $arr['id']];

        $student_id = $arr['student_id'];
        $asset_id = $arr['asset_id'];
        $booked_on = $arr['booked_on'];
        $submitted_on = $arr['submitted_on'];
        $location = $arr['location'];
        $status = $arr['status'];
        $quantity = $arr['quantity'];
        $id = $arr['id'];

        $query = $this->conn->prepare("UPDATE asset_movement set student_id =:student_id,asset_id=:asset_id,booked_on=:booked_on,submitted_on=:submitted_on,location=:location,status=:status,quantity=:quantity WHERE id=:id");

        $query->execute(array("student_id" => $student_id, "asset_id" => $asset_id, "booked_on" => $booked_on, "submitted_on" => $submitted_on, "location" => $location, "status" => $status, "quantity" => $quantity, "id" => $id));

        if ($query->rowCount() == 0) {
            $response = ['status' => 'fail', 'message' => "failed to update student", 'id' => $id, 'error' => $query->errorInfo()];
        }
        return $response;
    }
    function returnAsset($datas){
        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Asset updated successful</div>", 'id' => $datas['id']];

        $query = $this->conn->prepare("UPDATE asset_movement set submitted_on=CURRENT_TIMESTAMP WHERE id=:id");

        $query->execute(array("id" => $datas['id']));

        if ($query->rowCount() == 0) {
            $response = ['status' => 'fail', 'message' => "Asset returned successfully", 'id' => $datas['id'], 'error' => $query->errorInfo()];
        }
        return $response;

    }
}

?>