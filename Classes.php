<?php 
include_once "Database.php";

class Classes{

    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
    }


	function insertClass($arr){

		$response = ['status' => 'ok', 'message' => "Successful inserted", 'id' => 0];

	$name = $arr['name'];
    $academic_year = $arr['academic_year'];

	$query=$this->conn->prepare("INSERT INTO classes set name =:name,academic_year=:academic_year");
		$query->execute(array('name'=>$name,'academic_year'=>$academic_year));

		if ($query->rowCount()>0) {
    	$response ['message'] = "student added";
    	   $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "failed to add class", 'error' => $query->errorInfo()];
        }
        return $response;
    }
	
	function getAllClasses(){
		header("Content-Type:application");
		$query=$this->conn->query("SELECT * FROM classes");
		$data=$query->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}
	function getClassById($id){
      

		$query=$this->conn->prepare("SELECT * FROM classes where id=:id");
		$query->execute(array("id"=>$id));
		$data=$query->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($data);
		if ($query->rowCount()==0) {
			 echo "failed to delete".json_encode($query->errorInfo());
		}
		return $data;
	}
	function deleteClass($id){
		 $response = ['status' => 'ok', 'message' => "succesful fetched", 'id' => 0];

		$query=$this->conn->prepare("DELETE FROM classes WHERE id=:id");
		$query->execute(array("id"=>$id));
		if ($query->rowCount()==0) {
			$response = ['status' => 'fail', 'message' => "Failed to delete", 'id' => $id, "error" => $query->errorInfo()];
        }
        return $response;
    }
	function updateClass($arr){
		$response = ['status' => 'ok', 'message' => "Student succesful updated", 'id' => $arr['id']];

	$name = $arr['name'];
    $academic_year = $arr['academic_year'];
    $id = $arr['id'];

		$query=$this->conn->prepare("UPDATE classes set name =:name,academic_year=:academic_year WHERE id=:id");
		$query->execute(array("name"=>$name,"academic_year"=>$academic_year,"id"=>$id));
		if ($query->rowCount()>0) {
			$response = ['status' => 'fail', 'message' => "failed to update student", 'id' => $id, 'error' => $query->errorInfo()];
        }
        return $response;
    }
}
?>