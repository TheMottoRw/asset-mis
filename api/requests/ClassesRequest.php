<?php 
include_once "../classes/Classes.php";

$obj = new Classes();
//$obj->connect();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'POST':
        header("Content-Type:application/json");
        switch ($_POST['category']) {
			case 'insert':
				
			echo json_encode($obj->insertClass($_POST));
				break;
			case 'update':
				
				echo json_encode($obj->updateClass($_POST));
				break;
			
			default:
				# code...
				break;
		}
		break;
	case 'GET':
        header("Content-Type:application/json");
        switch ($_GET['category']) {
			case 'getById':
				$id=$_GET['id'];
				echo json_encode($obj->getClassById($id));
				// echo "Get Users By Id Requested";
				break;
			case 'get':
				echo json_encode($obj->getAllClasses());
				// echo "Get All Users Requested";
				break;
			case 'delete':
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