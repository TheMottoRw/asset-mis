<?php 
include_once "../classes/AssetMovement.php";
$obj=new AssetMovement();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
	case 'POST':
        header("Content-Type:application/json");
		switch ($_POST['category']) {
			case 'insert':
				echo json_encode($obj->insertAssetMovement($_POST));		
				break;
			case 'update':
				echo json_encode($obj->updateAssetMovement($_POST));
				break;
            case 'return':
                echo json_encode($obj->returnAsset($_POST));
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
				echo json_encode($obj->getAssetMovementById($id));
				break;
			case 'get':
				echo json_encode($obj->getAllAssetMovements());
				break;
			case 'delete':
				$id=$_GET['id'];
				echo json_encode($obj->deleteAssetMovement($id));
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