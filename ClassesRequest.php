<?php 
include_once "Classes.php";

$obj = new Classes();
//$obj->connect();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'POST':
		switch ($_POST['category']) {
			case 'insertClass':
				
			echo json_encode($obj->insertClass($_POST));
				echo "Insert Requested";
				break;
			case 'updateClass':
				
				echo json_encode($obj->updateClass($_POST));
				echo "Update Requested";
				break;
			
			default:
				# code...
				break;
		}
		break;
	case 'GET':
		switch ($_GET['category']) {
			case 'getClassById':
				$id=$_GET['id'];
				echo json_encode($obj->getClassById($id));
				// echo "Get Users By Id Requested";
				break;
			case 'getAllClasses':
				echo json_encode($obj->getAllClasses());
				// echo "Get All Users Requested";
				break;
			case 'deleteClass':
				$id=$_GET['id'];
				echo json_encode($obj->deleteClass($id));
				// echo "Delete Requested";
				break;
			default:
				# code...
				break;
		}
		break;
	
	default:
		echo "It Unknown request method";
		# code...
		break;
}
?>