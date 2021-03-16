<?php
include_once "Database.php";
include_once "Validator.php";
class Classes
{

    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
        $this->validate = new Validator();
    }


    function insertClass($arr)
    {

        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Class successful added</div>", 'id' => 0];

        $name = $arr['name'];
        $department = intval($arr['departments']);
        $academic_year = $arr['academic_year'];

        // validation
        $validationStatus = $this->validate->isEmpty(["Class name"=>$name,"Department"=>$department,"Academic year"=>$academic_year]);
        if($validationStatus['status']){
            return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        }
        // end validation
        $acyearValidationStatus = $this->validate->academicYear($academic_year);
        if(!$acyearValidationStatus['status']) return ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$acyearValidationStatus['message']."</div>"];

        $query = $this->conn->prepare("INSERT INTO classes set name =:name,department=:department,academic_year=:academic_year");
        $query->execute(array('name' => $name,'department' => $department, 'academic_year' => $academic_year));

        if ($query->rowCount() > 0) {
            $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to add class</div>", 'error' => [$query->errorInfo(),$arr]];
        }
        return $response;
    }

    function getAllClasses()
    {
        $query = $this->conn->query("SELECT c.*,d.names as dep_name FROM classes c INNER JOIN department d ON c.department=d.id");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getClassById($id)
    {


        $query = $this->conn->prepare("SELECT * FROM classes where id=:id");
        $query->execute(array("id" => $id));
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getByDepartment($arr)
    {
        $query = $this->conn->prepare("SELECT * FROM classes where department=:dep");
        $query->execute(array("dep" => $arr['department']));
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function deleteClass($id)
    {
        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Class successful deleted</div>", 'id' => $id];

        $query = $this->conn->prepare("DELETE FROM classes WHERE id=:id");
        $query->execute(array("id" => $id));
        if ($query->rowCount() == 0) {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to delete class</div>", 'id' => $id, "error" => $query->errorInfo()];
        }
        return $response;
    }

    function updateClass($arr)
    {
        $response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Class successful updated</div>", 'id' => $arr['id']];

        $name = $arr['name'];
        $academic_year = $arr['academic_year'];
        $id = $arr['id'];

        $acyearValidationStatus = $this->validate->academicYear($academic_year);
        if(!$acyearValidationStatus['status']) return ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$acyearValidationStatus['message']."</div>"];

        $query = $this->conn->prepare("UPDATE classes set name =:name,academic_year=:academic_year WHERE id=:id");
        $query->execute(array("name" => $name, "academic_year" => $academic_year, "id" => $id));
        if ($query->rowCount() > 0) {
            $response = ['status' => 'fail', 'message' => "<div class='alert danger'>Failed to update class</div>", 'id' => $id, 'error' => $query->errorInfo()];
        }
        return $response;
    }
}

?>