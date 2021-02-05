<?php 
include_once "../classes/Department.php";
$obj=new Department();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
	case 'POST':
        header("Content-Type:application/json");
        switch ($_POST['category']) {
			case 'insert':
				echo json_encode($obj->insertDepartment($_POST));
				break;
			case 'update':
			
				echo json_encode($obj->updateDepartment($_POST));
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
				echo json_encode($obj->getDepartmentById($id));
				// echo "Get Users By Id Requested";
				break;
			case 'get':
				echo json_encode($obj->getAllDepartments());
				// echo "Get All Users Requested";
				break;
			case 'delete':
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