<?php 
include_once "../classes/Assets.php";
$obj=new Assets();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
	case 'POST':
        header("Content-Type:application/json");
        switch ($_POST['category']) {
			case 'insert':
			echo json_encode($obj->insertAsset($_POST));
				break;
			case 'update':
			echo json_encode($obj->updateAsset($_POST));
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
			echo json_encode($obj->getAssetById($id));
				// echo "Get Users By Id Requested";
				break;
			case 'get':
				echo json_encode($obj->getAllAssets());
				// echo "Get All Users Requested";
				break;
			case 'delete':
				$id=$_GET['id'];
				echo json_encode($obj->deleteAsset($id));
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