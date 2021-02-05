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

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Asset given successful</div>", 'id' => 0];

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
        $query = $this->conn->query("SELECT * FROM asset_movement");
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
}

?>