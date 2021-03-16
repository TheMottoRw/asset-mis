<?php
include_once "Database.php";
include_once "Validator.php";

class LabTechnician
{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
        $this->validate = new Validator();
    }

    function insertLabTechnician($arr)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'> Successfully lab_technician registered</div>", 'id' => 0];

        $firstname = $arr['firstname'];
        $lastname = $arr['lastname'];
        $phone = $arr['phone'];
        $email = $arr['email'];

        $password = base64_encode($arr['password']);
        $dept_id = $arr['dept_id'];

        // validation
        $validationStatus = $this->validate->isEmpty(["Firstname"=>$firstname,"Lastname"=>$lastname,"Phone"=>$phone,"Email"=>$email]);
        if($validationStatus['status']){
            return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        }
        if(!$this->validate->phone("rwandan",$phone)) return ['status'=>'ok','message'=>"<div class='alert alert-danger'>Invalid phone number</div>"];
        if(!$this->validate->email($email)) return ['status'=>'ok','message'=>"<div class='alert alert-danger'>Invalid email address</div>"];
        // end validation

        $query = $this->conn->prepare("INSERT INTO lab_technician set firstname=:firstname,lastname=:lastname,email=:email,phone=:phone,password=:password,dept_id=:dept_id");

        $query->execute(array("firstname" => $firstname, "lastname" => $lastname, "email" => $email, "phone" => $phone, "password" => $password, "dept_id" => $dept_id));

        if ($query->rowCount() > 0) {
            $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to register lab_technician</div>", 'error' => $query->errorInfo()];
        }
        return $response;
    }

    function getAllLabTechnicians()
    {
        $query = $this->conn->query("SELECT e.*,d.names as dep_name FROM lab_technician e INNER JOIN department d ON e.dept_id=d.id");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getLabTechnicianById($id)
    {
        $query = $this->conn->prepare("SELECT * FROM lab_technician where id=:id");
        $query->execute(array("id" => $id));
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function deleteLabTechnician($id)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Successful deleted LabTechnician</div>", 'id' => 0];

        $query = $this->conn->prepare("DELETE FROM lab_technician WHERE id=:id");
        $query->execute(array("id" => $id));
        if ($query->rowCount() == 0) {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to delete lab_technician</div>", 'id' => $id, "error" => $query->errorInfo()];
        }
        return $response;
    }

    function updateLabTechnician($arr)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>LabTechnician succesful updated</div>", 'id' => 0];

        $firstname = $arr['firstname'];
        $lastname = $arr['lastname'];
        $phone = $arr['phone'];
        $email = $arr['email'];
        $dept_id = $arr['dept_id'];
        $id = $arr['id'];

        // validation
        $validationStatus = $this->validate->isEmpty(["Firstname"=>$firstname,"Lastname"=>$lastname,"Phone"=>$phone,"Email"=>$email]);
        if($validationStatus['status']){
            return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        }
        if(!$this->validate->phone("rwandan",$phone)) return ['status'=>'ok','message'=>"<div class='alert alert-danger'>Invalid phone number</div>"];
        if(!$this->validate->email($email)) return ['status'=>'ok','message'=>"<div class='alert alert-danger'>Invalid email address</div>"];
        // end validation

        $query = $this->conn->prepare("UPDATE lab_technician set firstname =:firstname,lastname=:lastname,email=:email,phone=:phone,dept_id=:dept_id WHERE id=:id");
        $query->execute(array("firstname" => $firstname, "lastname" => $lastname, "email" => $email, "phone" => $phone,  "dept_id" => $dept_id, "id" => $id));

        if ($query->rowCount() == 0) {

            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to update student</div>", 'id' => $id, 'error' => $query->errorInfo()];
        }
        return $response;
    }
}

?>