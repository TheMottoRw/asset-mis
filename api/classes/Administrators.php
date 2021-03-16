<?php
include_once "Database.php";

class Administrators
{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
    }

    function insertAdministrator($arr)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'> Successfully administrators registered</div>", 'id' => 0];

        $firstname = $arr['firstname'];
        $lastname = $arr['lastname'];
        $phone = $arr['phone'];
        $email = $arr['email'];

        $password = base64_encode($arr['password']);

        $query = $this->conn->prepare("INSERT INTO administrators set firstname=:firstname,lastname=:lastname,email=:email,phone=:phone,password=:password");

        $query->execute(array("firstname" => $firstname, "lastname" => $lastname, "email" => $email, "phone" => $phone, "password" => $password));

        if ($query->rowCount() > 0) {
            $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to register administrators</div>", 'error' => $query->errorInfo()];
        }
        return $response;
    }

    function getAllAdministrators()
    {
        $query = $this->conn->query("SELECT * FROM administrators");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getAdministratorById($id)
    {
        $query = $this->conn->prepare("SELECT * FROM administrators where id=:id");
        $query->execute(array("id" => $id));
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function deleteAdministrator($id)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Successful deleted Administrator</div>", 'id' => 0];

        $query = $this->conn->prepare("DELETE FROM administrators WHERE id=:id");
        $query->execute(array("id" => $id));
        if ($query->rowCount() == 0) {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to delete administrators</div>", 'id' => $id, "error" => $query->errorInfo()];
        }
        return $response;
    }

    function updateAdministrator($arr)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Administrator succesful updated</div>", 'id' => 0];

        $firstname = $arr['firstname'];
        $lastname = $arr['lastname'];
        $phone = $arr['phone'];
        $email = $arr['email'];
        $id = $arr['id'];

        $query = $this->conn->prepare("UPDATE administrators set firstname =:firstname,lastname=:lastname,email=:email,phone=:phone WHERE id=:id");
        $query->execute(array("firstname" => $firstname, "lastname" => $lastname, "email" => $email, "phone" => $phone, "id" => $id));

        if ($query->rowCount() == 0) {

            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to update administrator</div>", 'id' => $id, 'error' => $query->errorInfo()];
        }
        return $response;
    }
}

?>