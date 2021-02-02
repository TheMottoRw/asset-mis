<?php 
include_once "AssetMovement.php";
$obj=new AssetMovement();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
	case 'POST':
		switch ($_POST['category']) {
			case 'insertAssetMovement':
				echo json_encode($obj->insertAssetMovement($_POST))		
				break;

			case 'updateAssetMovement':
				
				echo json_encode($obj->updateAssetMovement($_POST));
				echo "Update Requested";
				break;
			
			default:
				# code...
				break;
		}
		break;
	case 'GET':
		switch ($_GET['category']) {
			case 'getAssetMovementById':
				$id=$_GET['id'];
				echo json_encode($obj->getAssetMovementById($id);
				// echo "Get Users By Id Requested";
				break;
			case 'getAllAssetMovements':
				echo json_encode($obj->getAllAssetMovements());
				// echo "Get All Users Requested";
				break;
			case 'deleteAssetMovement':
				$id=$_GET['id'];
				echo json_encode($obj->deleteAssetMovement($id));
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