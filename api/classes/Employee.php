<?php
include_once "Database.php";
include_once "Validator.php";

class Employee
{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
        $this->validate = new Validator();
    }

    function insertEmployee($arr)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'> Successfully teacher registered</div>", 'id' => 0];

        $firstname = $arr['firstname'];
        $lastname = $arr['lastname'];
        $phone = $arr['phone'];
        $email = $arr['email'];

        $password = base64_encode($arr['password']);
        $dept_id = $arr['dept_id'];
        $role = $arr['roles'];

        // validation
        $validationStatus = $this->validate->isEmpty(["Firstname"=>$firstname,"Lastname"=>$lastname,"Phone"=>$phone,"Email"=>$email]);
        if($validationStatus['status']){
            return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        }
        if(!$this->validate->phone("rwandan",$phone)) return ['status'=>'ok','message'=>"<div class='alert alert-danger'>Invalid phone number</div>"];
        if(!$this->validate->email($email)) return ['status'=>'ok','message'=>"<div class='alert alert-danger'>Invalid email address</div>"];
        // end validation

        $query = $this->conn->prepare("INSERT INTO employee set firstname=:firstname,lastname=:lastname,email=:email,phone=:phone,role=:role,password=:password,dept_id=:dept_id");

        $query->execute(array("firstname" => $firstname, "lastname" => $lastname, "email" => $email, "phone" => $phone, "role" => $role, "password" => $password, "dept_id" => $dept_id));

        if ($query->rowCount() > 0) {
            $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to register teacher</div>", 'error' => $query->errorInfo()];
        }
        return $response;
    }

    function getAllEmployees()
    {
        $query = $this->conn->query("SELECT e.*,d.names as dep_name FROM employee e INNER JOIN department d ON e.dept_id=d.id");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getEmployeeById($id)
    {
        $query = $this->conn->prepare("SELECT * FROM employee where id=:id");
        $query->execute(array("id" => $id));
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function deleteEmployee($id)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Successful deleted Employee</div>", 'id' => 0];

        $query = $this->conn->prepare("DELETE FROM employee WHERE id=:id");
        $query->execute(array("id" => $id));
        if ($query->rowCount() == 0) {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to delete employee</div>", 'id' => $id, "error" => $query->errorInfo()];
        }
        return $response;
    }

    function updateEmployee($arr)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Teacher succesfully updated</div>", 'id' => 0];

        $firstname = $arr['firstname'];
        $lastname = $arr['lastname'];
        $phone = $arr['phone'];
        $email = $arr['email'];
        $dept_id = $arr['dept_id'];
        $role = $arr['role'];
        $id = $arr['id'];
        // validation
        $validationStatus = $this->validate->isEmpty(["Firstname"=>$firstname,"Lastname"=>$lastname,"Phone"=>$phone,"Email"=>$email]);
        if($validationStatus['status']){
            return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        }
        if(!$this->validate->phone("rwandan",$phone)) return ['status'=>'ok','message'=>"<div class='alert alert-danger'>Invalid phone number</div>"];
        if(!$this->validate->email($email)) return ['status'=>'ok','message'=>"<div class='alert alert-danger'>Invalid email address</div>"];
        // end validation

        $query = $this->conn->prepare("UPDATE employee set firstname =:firstname,lastname=:lastname,email=:email,phone=:phone,role=:role,dept_id=:dept_id WHERE id=:id");
        $query->execute(array("firstname" => $firstname, "lastname" => $lastname, "email" => $email, "phone" => $phone, "role" => $role, "dept_id" => $dept_id, "id" => $id));

        if ($query->rowCount() == 0) {

            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to update student</div>", 'id' => $id, 'error' => $query->errorInfo()];
        }
        return $response;
    }
}

?>