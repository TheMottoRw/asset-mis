<?php
include_once "Database.php";
include_once "Validator.php";
include_once "Reservation.php";

class Assets
{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
        $this->validate = new Validator();
        $this->reservation = new Reservation();
        $this->reservation->cancelExpiredReservation();
    }


    function insertAsset($arr)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Successful inserted</div>", 'id' => 0];

        $names = $arr['names'];
        $state = $arr['state'];
        $description = $arr['description'];
        $code = $arr['code'];
        $dept_id = $arr['departments'];
        $serial_number = $arr['serial_number'];
        $type = $arr['type'];

        // validation
        $validationStatus = $this->validate->isEmpty(["Asset name"=>$names,"Asset code"=>$code,"Department"=>$dept_id,"Serial number"=>$serial_number,"Type"=>$type]);
        if($validationStatus['status']){
            return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        }
        // end validation

        $query = $this->conn->prepare("INSERT INTO assets set names =:names,state=:state,description=:description,code=:code,serial_number=:serial_number,type=:type,dept_id=:dept_id");

        $query->execute(array("names" => $names, "state" => $state, "description" => $description, "code" => $code, "serial_number" => $serial_number, "type" => $type, "dept_id" => $dept_id));

        if ($query->rowCount() > 0) {
            $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to add asset</div>", 'error' => [$query->errorInfo(),$arr]];
        }
        return $response;
    }

    function getAllAssets()
    {
        $query = $this->conn->query("SELECT a.*,d.names as dep_name FROM assets a INNER JOIN department d ON d.id=a.dept_id");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getAvailableAsset(){
        $query = $this->conn->query("SELECT a.*,d.names as dep_name FROM assets a INNER JOIN department d ON d.id=a.dept_id WHERE a.id NOT IN (SELECT asset_id FROM asset_movement WHERE given_on IS NULL)");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    function getAssetById($id)
    {
        $query = $this->conn->prepare("SELECT * FROM assets where id=:id");
        $query->execute(array("id" => $id));
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
        if ($query->rowCount() == 0) {
            return [];
        }
        return $data;
    }

    function deleteAsset($id)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Asset successful deleted</div>", 'id' => $id];

        $query = $this->conn->prepare("DELETE FROM assets WHERE id=:id");
        $query->execute(array("id" => $id));
        if ($query->rowCount() == 0) {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to delete</div>", 'id' => $id, "error" => $query->errorInfo()];
        }
        return $response;
    }

    function updateAsset($arr)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Asset succesful updated</div>", 'id' => $arr['id']];

        $names = $arr['names'];
        $state = $arr['state'];
        $description = $arr['description'];
        $code = $arr['code'];
        $dept_id = $arr['departments'];
        $serial_number = $arr['serial_number'];
        $type = $arr['type'];
        $id = $arr['id'];

        // validation
        $validationStatus = $this->validate->isEmpty(["Asset name"=>$names,"Asset code"=>$code,"Department"=>$dept_id,"Serial number"=>$serial_number,"Type"=>$type]);
        if($validationStatus['status']){
            return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        }
        // end validation

        $query = $this->conn->prepare("UPDATE assets set names =:names,state=:state,description=:description,code=:code,serial_number=:serial_number,type=:type,dept_id=:dept_id WHERE id=:id");

        $query->execute(array("names" => $names, "state" => $state, "description" => $description, "code" => $code, "serial_number" => $serial_number, "type" => $type, "dept_id" => $dept_id, "id" => $id));

        if ($query->rowCount() > 0) {
            $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to add asset</div>", 'error' => [$query->errorInfo(),$arr]];
        }
        return $response;
    }
}

?>