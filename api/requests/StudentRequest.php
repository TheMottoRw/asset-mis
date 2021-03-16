<?php 
include_once "../classes/Student.php";
$obj=new Student();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
	case 'POST':
        header("Content-Type:application/json");
        switch ($_POST['category']) {
			case 'insert':
				
				echo json_encode($obj->insertStudent($_POST));
				break;
			case 'update':
				
				echo json_encode($obj->updateStudent($_POST));
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
				echo json_encode($obj->getStudentById($id));
				// echo "Get Users By Id Requested";
				break;
			case 'get':
				echo json_encode($obj->getAllStudents());
				// echo "Get All Users Requested";
				break;
            case 'whotoborrow':
                echo json_encode($obj->getWhoToBorrow());
                break;
            case 'delete':
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