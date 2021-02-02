<?php 
include_once "Assets.php";
$obj=new Assets();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
	case 'POST':
		switch ($_POST['category']) {
			case 'insertAsset':	
			echo json_encode($obj->insertAsset($_POST));
				echo "Insert Requested";
				break;
			case 'updateAsset':
			echo json_encode($obj->updateAsset($_POST));
				echo "Update Requested";
				break;
			
			default:
				# code...
				break;
		}
		break;
	case 'GET':
		switch ($_GET['category']) {
			case 'getAssetById':
				$id=$_GET['id'];
			echo json_encode($obj->getAssetById($id));
				// echo "Get Users By Id Requested";
				break;
			case 'getAllAssets':
				echo json_encode($obj->getAllAssets());
				// echo "Get All Users Requested";
				break;
			case 'deleteAsset':
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