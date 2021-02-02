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

	function insertDepartment($arr){

		$response = ['status' => 'ok', 'message' => "Successful inserted", 'id' => 0];

     $acronym = $arr['acronym'];
     $names = $arr['names'];
     $location = $arr['location'];
     
   
		$query=$this->conn->prepare("INSERT INTO department set acronym =:acronym,names=:names,location=:location");

		$query->execute(array("acronym"=>$acronym,"names"=>$names,"location"=>$location));

        if ($query->rowCount()>0) {
    	$response ['message'] = "student added";
    	   $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "failed to add student", 'error' => $query->errorInfo()];
        }
        return $response;
    }
	
	function getAllDepartments(){
		header("Content-Type:application");
		$query=$this->conn->query("SELECT * FROM department");
		$data=$query->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}
	function getDepartmentById($id){
		$query=$this->conn->prepare("SELECT * FROM department where id=:id");
		$query->execute(array("id"=>$id));
		$data=$query->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($data);
		if ($query->rowCount()==0) {
			return [];
		}
		return $data;
	}
	function deleteDepartment($id){

		$response = ['status' => 'ok', 'message' => "Successful deleted document type", 'id' => $id];

		$query=$this->conn->prepare("DELETE FROM department WHERE id=:id");
		$query->execute(array("id"=>$id));

		if ($query->rowCount()==0) {
			$response = ['status' => 'fail', 'message' => "Failed to delete", 'id' => $id, "error" => $query->errorInfo()];
        }
        return $response;
    }
	
	function updateDepartment($arr){

		$response = ['status' => 'ok', 'message' => "Student succesful updated", 'id' => $arr['id']];

	 $acronym = $arr['acronym'];
     $names = $arr['names'];
     $location = $arr['location'];
     $id = $arr['id'];


		$query=$this->conn->prepare("UPDATE department set acronym =:acronym,names=:names,location=:location WHERE id=:id");
		$query->execute(array("acronym"=>$acronym,"names"=>$names,"location"=>$location,"id"=>$id));

		if ($query->rowCount()==0) {

	    $response = ['status' => 'fail', 'message' => "failed to update student", 'id' => $id, 'error' => $query->errorInfo()];
        }
        return $response;
    }
}
?>