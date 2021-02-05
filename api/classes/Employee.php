<?php
include_once "Database.php";

class Employee
{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
    }

    function insertEmployee($arr)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'> Successfully employee registered</div>", 'id' => 0];

        $firstname = $arr['firstname'];
        $lastname = $arr['lastname'];
        $phone = $arr['phone'];
        $email = $arr['email'];

        $password = base64_encode($arr['password']);
        $dept_id = $arr['dept_id'];
        $role = $arr['role'];

        $query = $this->conn->prepare("INSERT INTO employee set firstname=:firstname,lastname=:lastname,email=:email,phone=:phone,role=:role,password=:password,dept_id=:dept_id");

        $query->execute(array("firstname" => $firstname, "lastname" => $lastname, "email" => $email, "phone" => $phone, "role" => $role, "password" => $password, "dept_id" => $dept_id));

        if ($query->rowCount() > 0) {
            $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to register employee</div>", 'error' => $query->errorInfo()];
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

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Employee succesful updated</div>", 'id' => 0];

        $firstname = $arr['firstname'];
        $lastname = $arr['lastname'];
        $phone = $arr['phone'];
        $email = $arr['email'];
        $dept_id = $arr['dept_id'];
        $role = $arr['role'];
        $id = $arr['id'];

        $query = $this->conn->prepare("UPDATE employee set firstname =:firstname,lastname=:lastname,email=:email,phone=:phone,role=:role,dept_id=:dept_id WHERE id=:id");
        $query->execute(array("firstname" => $firstname, "lastname" => $lastname, "email" => $email, "phone" => $phone, "role" => $role, "dept_id" => $dept_id, "id" => $id));

        if ($query->rowCount() == 0) {

            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to update student</div>", 'id' => $id, 'error' => $query->errorInfo()];
        }
        return $response;
    }
}

?>