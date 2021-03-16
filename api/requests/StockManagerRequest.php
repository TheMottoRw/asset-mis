<?php
include_once "../classes/StockManager.php";
$obj=new StockManager();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'POST':
        header("Content-Type:application/json");
        switch ($_POST['category']) {
            case 'insert':
                echo json_encode($obj->insertStockManager($_POST));
                break;
            case 'update':

                echo json_encode($obj->updateStockManager($_POST));
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
                echo json_encode($obj->getStockManagerById($id));
                break;
            case 'get':
                echo json_encode($obj->getAllStockManagers());
                break;
            case 'delete':
                $id=$_GET['id'];
                echo json_encode($obj->deleteStockManager($id));
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