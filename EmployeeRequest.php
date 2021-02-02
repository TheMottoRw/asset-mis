<?php 
include_once "Employee.php";
$obj=new Employee();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
	case 'POST':
		switch ($_POST['category']) {
			case 'insertEmployee':
				echo json_encode($obj->insertEmployee($_POST));
				echo "Insert Requested";
				break;
			case 'updateEmployee':
			
				echo json_encode($obj->updateEmployee($_POST));
				echo "Update Requested";
				break;
			
			default:
				# code...
				break;
		}
		break;
	case 'GET':
		switch ($_GET['category']) {
			case 'getEmployeeById':
				$id=$_GET['id'];
				echo json_encode($obj->getEmployeeById($id));
				// echo "Get Users By Id Requested";
				break;
			case 'getAllEmployees':
				echo json_encode($obj->getAllEmployees());
				// echo "Get All Users Requested";
				break;
			case 'deleteEmployee':
				$id=$_GET['id'];
			   echo json_encode($obj->deleteEmployee($id));
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