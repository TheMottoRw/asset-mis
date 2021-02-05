<?php

include_once "Database.php";

class Department
{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
    }

    function insertDepartment($arr)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Successfully department added</div>", 'id' => 0];

        $acronym = $arr['acronym'];
        $names = $arr['names'];

        $query = $this->conn->prepare("INSERT INTO department set acronym =:acronym,names=:names");

        $query->execute(array("acronym" => $acronym, "names" => $names));

        if ($query->rowCount() > 0) {
            $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to add department</div>", 'error' => $query->errorInfo()];
        }
        return $response;
    }

    function getAllDepartments()
    {
        $query = $this->conn->query("SELECT * FROM department");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getDepartmentById($id)
    {
        $query = $this->conn->prepare("SELECT * FROM department where id=:id");
        $query->execute(array("id" => $id));
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($query->rowCount() == 0) {
            return [];
        }
        return $data;
    }

    function deleteDepartment($id)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Successful deleted department</div>", 'id' => $id];

        $query = $this->conn->prepare("DELETE FROM department WHERE id=:id");
        $query->execute(array("id" => $id));

        if ($query->rowCount() == 0) {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to delete</div>", 'id' => $id, "error" => $query->errorInfo()];
        }
        return $response;
    }

    function updateDepartment($arr)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Successfully updated department</div>", 'id' => $arr['id']];

        $acronym = $arr['acronym'];
        $names = $arr['names'];
        $id = $arr['id'];


        $query = $this->conn->prepare("UPDATE department set acronym =:acronym,names=:names WHERE id=:id");
        $query->execute(array("acronym" => $acronym, "names" => $names, "id" => $id));

        if ($query->rowCount() == 0) {

            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to update department</div>", 'id' => $id, 'error' => $query->errorInfo()];
        }
        return $response;
    }
}

?>