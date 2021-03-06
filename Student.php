<?php 
include_once "Database.php";

class Student
{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
    }

	function insertStudent($arr){

	$response = ['status' => 'ok', 'message' => "Successful inserted", 'id' => 0];
	
    $firstname = $arr['firstname'];
    $lastname = $arr['lastname'];
    $reg_number = $arr['reg_number'];
    $email = $arr['email'];
    $password = base64_encode($arr['password']);
    $dept_id = $arr['dept_id'];
    $class_id = $arr['class_id'];


	$query=$this->conn->prepare("INSERT INTO student set firstname =:firstname,lastname=:lastname,reg_number=:reg_number,email=:email,password=:password,dept_id=:dept_id,class_id=:class_id");

	$query->execute(array("firstname"=>$firstname,"lastname"=>$lastname,"reg_number"=>$reg_number,"email"=>$email,"password"=>$password,"dept_id"=>$dept_id,"class_id"=>$class_id));

    if ($query->rowCount()>0) {
    	$response ['message'] = "student added";
    	   $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "failed to add student", 'error' => $query->errorInfo()];
        }
        return $response;
    }

	function getAllStudents(){
		header("Content-Type:application");
		$query=$this->conn->query("SELECT * FROM student");
		$data=$query->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}
	function getStudentById($id){
		$query=$this->conn->prepare("SELECT * FROM student where id=:id");
		$query->execute(array("id"=>$id));
		$data=$query->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($data);
		if ($query->rowCount()==0) {
			return [];
		}
		return $data;
	}
	function deleteStudent($id){

		$response = ['status' => 'ok', 'message' => "Successful deleted Student", 'id' => $id];

		$query=$this->conn->prepare("DELETE FROM student WHERE id=:id");
		$query->execute(array("id"=>$id));
		if ($query->rowCount()==0) {
			$response = ['status' => 'fail', 'message' => "Failed to delete", 'id' => $id, "error" => $query->errorInfo()];
        }
        return $response;
    }
	function updateStudent($arr){

	$response = ['status' => 'ok', 'message' => "Student succesful updated", 'id' => $arr['id']];

    $firstname = $arr['firstname'];
    $lastname = $arr['lastname'];
    $reg_number = $arr['reg_number'];
    $email = $arr['email'];
    $dept_id = $arr['dept_id'];
    $class_id = $arr['class_id'];
    $id = $arr['id'];


	$query=$this->conn->prepare("UPDATE student set firstname =:firstname,lastname=:lastname,reg_number=:reg_number,email=:email,dept_id=:dept_id,class_id=:class_id WHERE id=:id");


	$query->execute(array("firstname"=>$firstname,"lastname"=>$lastname,"reg_number"=>$reg_number,"email"=>$email,"dept_id"=>$dept_id,"class_id"=>$class_id,"id"=>$id));
		if ($query->rowCount()==0) {

	    $response = ['status' => 'fail', 'message' => "failed to update student", 'id' => $id, 'error' => $query->errorInfo()];
        }
        return $response;
    }
}
?>