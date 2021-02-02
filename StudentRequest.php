<?php 
include_once "Student.php";
$obj=new Student();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
	case 'POST':
		switch ($_POST['categeory']) {
			case 'insertStudent':
				
				echo json_encode($obj->insertStudent($_POST));
				echo "Insert Requested";
				break;
			case 'updateStudent':
				
				echo json_encode($obj->updateStudent($_POST));
				echo "Update Requested";
				break;
			
			default:
				# code...
				break;
		}
		break;
	case 'GET':
		switch ($_GET['categeory']) {
			case 'getStudentById':
				$id=$_GET['id'];
				echo json_encode($obj->getStudentById($id));
				// echo "Get Users By Id Requested";
				break;
			case 'getAllStudents':
				echo json_encode($obj->getAllStudents());
				// echo "Get All Users Requested";
				break;
			case 'deleteStudent':
				$id=$_GET['id'];
				echo json_encode($obj->deleteStudent($id));
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