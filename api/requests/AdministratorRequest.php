<?php
include_once "../classes/Administrators.php";
$obj=new Administrators();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'POST':
        header("Content-Type:application/json");
        switch ($_POST['category']) {
            case 'insert':
                echo json_encode($obj->insertAdministrator($_POST));
                break;
            case 'update':

                echo json_encode($obj->updateAdministrator($_POST));
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
                echo json_encode($obj->getAdministratorById($id));
                break;
            case 'get':
                echo json_encode($obj->getAllAdministrators());
                break;
            case 'delete':
                $id=$_GET['id'];
                echo json_encode($obj->deleteAdministrator($id));
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