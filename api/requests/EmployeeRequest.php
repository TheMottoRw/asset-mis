<?php 
include_once "../classes/Employee.php";
$obj=new Employee();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
	case 'POST':
        header("Content-Type:application/json");
        switch ($_POST['category']) {
			case 'insert':
				echo json_encode($obj->insertEmployee($_POST));
				break;
			case 'update':
			
				echo json_encode($obj->updateEmployee($_POST));
				echo "Update Requested";
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
				echo json_encode($obj->getEmployeeById($id));
				break;
			case 'get':
				echo json_encode($obj->getAllEmployees());
				break;
			case 'delete':
				$id=$_GET['id'];
			   echo json_encode($obj->deleteEmployee($id));
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