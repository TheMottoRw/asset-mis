<?php 
include_once "Department.php";
$obj=new Department();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
	case 'POST':
		switch ($_POST['category']) {
			case 'insertDepartment':
				
				echo json_encode($obj->insertDepartment($_POST));
				echo "Insert Requested";
				break;
			case 'updateDepartment':
			
				echo json_encode($obj->updateDepartment($id,$acronym,$names,$location));
				echo "Update Requested";
				break;
			
			default:
				# code...
				break;
		}
		break;
	case 'GET':
		switch ($_GET['category']) {
			case 'getDepartmentById':
				$id=$_GET['id'];
				echo json_encode($obj->getDepartmentById($id));
				// echo "Get Users By Id Requested";
				break;
			case 'getAllDepartments':
				echo json_encode($obj->getAllDepartments());
				// echo "Get All Users Requested";
				break;
			case 'deleteDepartment':
				$id=$_GET['id'];
				echo json_encode($obj->deleteDepartment($id));
				// echo "Delete Requested";
				break;
			default:
				# code...
				break;
		}
		break;
	
	default:
		echo "It Unknown request method";
		break;
}
?>