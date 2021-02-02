<?php 
include_once "Database.php";
class Assets
	{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
    }


	function insertAsset($arr){

	$response = ['status' => 'ok', 'message' => "Successful inserted", 'id' => 0];
	
    $name = $arr['name'];
    $state = $arr['state'];
    $description = $arr['description'];
    $code = $arr['code'];
    $dept_id = $arr['dept_id'];
    $serial_number = $arr['serial_number'];
    $type = $arr['type'];


		$query=$this->conn->prepare("INSERT INTO assets set names =:names,state=:state,description=:description,code=:code,serial_number=:serial_number,type=:type,dept_id=:dept_id");

		$query->execute(array("names"=>$names,"state"=>$state,"description"=>$description,"code"=>$code,"serial_number"=>$serial_number,"type"=>$type,"dept_id"=>$dept_id));
		
		if ($query->rowCount()>0) {
    	$response ['message'] = "student added";
    	   $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "failed to add student", 'error' => $query->errorInfo()];
        }
        return $response;
    }
	
	function getAllAssets(){
		header("Content-Type:application");
		$query=$this->conn->query("SELECT * FROM assets");
		$data=$query->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}
	function getAssetById($id){
		$query=$this->conn->prepare("SELECT * FROM assets where id=:id");
		$query->execute(array("id"=>$id));
		$data=$query->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($data);
		if ($query->rowCount()==0) {
			return [];
		}
		return $data;
	}
	function deleteAsset($id){

		$response = ['status' => 'ok', 'message' => "Asset successful deleted ", 'id' => 0];

		$query=$this->conn->prepare("DELETE FROM assets WHERE id=:id");
		$query->execute(array("id"=>$id));
		if ($query->rowCount()==0) {
			$response = ['status' => 'fail', 'message' => "Failed to delete", 'id' => $id, "error" => $query->errorInfo()];
        }
        return $response;
    }
	function updateAsset($arr){

	$response = ['status' => 'ok', 'message' => "Asset succesful updated", 'id' => $arr['id']];

	$name = $arr['name'];
    $state = $arr['state'];
    $description = $arr['description'];
    $code = $arr['code'];
    $dept_id = $arr['dept_id'];
    $serial_number = $arr['serial_number'];
    $type = $arr['type'];
    $id = $arr['id'];


		$query=$this->conn->prepare("UPDATE assets set names =:names,state=:state,description=:description,code=:code,serial_number=:serial_number,type=:type,dept_id=:dept_id WHERE id=:id");

		$query->execute(array("names"=>$names,"state"=>$state,"description"=>$description,"code"=>$code,"serial_number"=>$serial_number,"type"=>$type,"dept_id"=>$dept_id,"id"=>$id));

		if ($query->rowCount()==0) {
			$response = ['status' => 'fail', 'message' => "failed to update Asset", 'id' => $id, 'error' => $query->errorInfo()];
        }
        return $response;
    }
}
?>