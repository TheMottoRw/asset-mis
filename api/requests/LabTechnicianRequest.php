<?php
include_once "../classes/LabTechnician.php";
$obj=new LabTechnician();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'POST':
        header("Content-Type:application/json");
        switch ($_POST['category']) {
            case 'insert':
                echo json_encode($obj->insertLabTechnician($_POST));
                break;
            case 'update':

                echo json_encode($obj->updateLabTechnician($_POST));
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
                echo json_encode($obj->getLabTechnicianById($id));
                break;
            case 'get':
                echo json_encode($obj->getAllLabTechnicians());
                break;
            case 'delete':
                $id=$_GET['id'];
                echo json_encode($obj->deleteLabTechnician($id));
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