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

	function insertEmployee($arr){

	$response = ['status' => 'ok', 'message' => "Successful inserted", 'id' => 0];
	
    $firstname = $arr['firstname'];
    $lastname = $arr['lastname'];
    $phone = $arr['phone'];
    $email = $arr['email'];
    
    $password = base64_encode($arr['password']);
    $dept_id = $arr['dept_id'];
    $role = $arr['role'];

    $query=$this->conn->prepare("INSERT INTO employee set firstname =:firstname,lastname=:lastname,email=:email,phone=:phone,role=:role,password=:password,dept_id=:dept_id");

	$query->execute(array("firstname"=>$firstname,"lastname"=>$lastname,"email"=>$email,"phone"=>$phone,"role"=>$role,"password"=>$password,"dept_id"=>$dept_id));

	if ($query->rowCount()>0) {
    	$response ['message'] = "student added";
    	   $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "failed to add student", 'error' => $query->errorInfo()];
        }
        return $response;
    }
	
	function getAllEmployees(){
		header("Content-Type:application");
		$query=$this->conn->query("SELECT * FROM employee");
		$data=$query->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}
	function getEmployeeById($id){
		$query=$this->conn->prepare("SELECT * FROM employee where id=:id");
		$query->execute(array("id"=>$id));
		$data=$query->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($data);
		if ($query->rowCount()==0) {
			return [];
		}
		return $data;
	}
	function deleteEmployee($id){

		$response = ['status' => 'ok', 'message' => "Successful deleted Student", 'id' => 0];

		$query=$this->conn->prepare("DELETE FROM employee WHERE id=:id");
		$query->execute(array("id"=>$id));
		if ($query->rowCount()==0) {
			$response = ['status' => 'fail', 'message' => "Failed to delete", 'id' => $id, "error" => $query->errorInfo()];
        }
        return $response;
    }
	
	function updateEmployee($arr){

	$response = ['status' => 'ok', 'message' => "Student succesful updated", 'id' => 0];

    $firstname = $arr['firstname'];
    $lastname = $arr['lastname'];
    $phone = $arr['phone'];
    $email = $arr['email'];
    $dept_id = $arr['dept_id'];
    $role = $arr['role'];
    $id = $arr['id'];

		$query=$this->conn->prepare("UPDATE employee set firstname =:firstname,lastname=:lastname,email=:email,phone=:phone,role=:role,dept_id=:dept_id WHERE id=:id");
		$query->execute(array("firstname"=>$firstname,"lastname"=>$lastname,"email"=>$email,"phone"=>$phone,"role"=>$role,"dept_id"=>$dept_id,"id"=>$id));

		if ($query->rowCount()==0) {

	    $response = ['status' => 'fail', 'message' => "failed to update student", 'id' => $id, 'error' => $query->errorInfo()];
        }
        return $response;
    }
}
?>