<?php
include_once "Database.php";
include_once "Validator.php";

class StockManager
{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
        $this->validate = new Validator();
    }

    function insertStockManager($arr)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'> Successfully stock manager registered</div>", 'id' => 0];

        $firstname = $arr['firstname'];
        $lastname = $arr['lastname'];
        $phone = $arr['phone'];
        $email = $arr['email'];

        $password = base64_encode($arr['password']);
        // validation
        $validationStatus = $this->validate->isEmpty(["Firstname"=>$firstname,"Lastname"=>$lastname,"Phone"=>$phone,"Email"=>$email]);
        if($validationStatus['status']){
            return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        }
        if(!$this->validate->phone("rwandan",$phone)) return ['status'=>'ok','message'=>"<div class='alert alert-danger'>Invalid phone number</div>"];
        if(!$this->validate->email($email)) return ['status'=>'ok','message'=>"<div class='alert alert-danger'>Invalid email address</div>"];
        // end validation
        $query = $this->conn->prepare("INSERT INTO stock_manager set firstname=:firstname,lastname=:lastname,email=:email,phone=:phone,password=:password");

        $query->execute(array("firstname" => $firstname, "lastname" => $lastname, "email" => $email, "phone" => $phone, "password" => $password));

        if ($query->rowCount() > 0) {
            $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to register stock manager</div>", 'error' => $query->errorInfo()];
        }
        return $response;
    }

    function getAllStockManagers()
    {
        $query = $this->conn->query("SELECT * FROM stock_manager");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getStockManagerById($id)
    {
        $query = $this->conn->prepare("SELECT * FROM stock_manager where id=:id");
        $query->execute(array("id" => $id));
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function deleteStockManager($id)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Successful deleted Stock manager</div>", 'id' => 0];

        $query = $this->conn->prepare("DELETE FROM stock_manager WHERE id=:id");
        $query->execute(array("id" => $id));
        if ($query->rowCount() == 0) {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to delete stock manager</div>", 'id' => $id, "error" => $query->errorInfo()];
        }
        return $response;
    }

    function updateStockManager($arr)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Stock manager succesful updated</div>", 'id' => 0];

        $firstname = $arr['firstname'];
        $lastname = $arr['lastname'];
        $phone = $arr['phone'];
        $email = $arr['email'];
        $id = $arr['id'];

        // validation
        $validationStatus = $this->validate->isEmpty(["Firstname"=>$firstname,"Lastname"=>$lastname,"Phone"=>$phone,"Email"=>$email]);
        if($validationStatus['status']){
            return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        }
        if(!$this->validate->phone("rwandan",$phone)) return ['status'=>'ok','message'=>"<div class='alert alert-danger'>Invalid phone number</div>"];
        if(!$this->validate->email($email)) return ['status'=>'ok','message'=>"<div class='alert alert-danger'>Invalid email address</div>"];
        // end validation

        $query = $this->conn->prepare("UPDATE stock_manager set firstname =:firstname,lastname=:lastname,email=:email,phone=:phone WHERE id=:id");
        $query->execute(array("firstname" => $firstname, "lastname" => $lastname, "email" => $email, "phone" => $phone, "id" => $id));

        if ($query->rowCount() == 0) {

            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to update stock manager</div>", 'id' => $id, 'error' => $query->errorInfo()];
        }
        return $response;
    }
}

?>