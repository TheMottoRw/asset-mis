<?php
include_once "../classes/Reservation.php";

$obj = new Reservation();
//$obj->connect();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        header("Content-Type:application/json");
        switch ($_POST['category']) {
            case 'insert':

                echo json_encode($obj->save($_POST));
                break;
            case 'taken':
                echo json_encode($obj->taken($_POST));
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
                echo json_encode($obj->get());
                // echo "Get Users By Id Requested";
                break;
            case 'get':
                echo json_encode($obj->get($_GET));
                // echo "Get All Users Requested";
                break;
            case 'byuser':
                echo json_encode($obj->getUserReservation($_GET));
                // echo "Get All Users Requested";
                break;
            case 'bystudent':
                echo json_encode($obj->getByStudent($_GET));
                // echo "Get All Users Requested";
                break;
            case 'getbydepartment':
                echo json_encode($obj->getByDepartment($_GET));
                // echo "Get All Users Requested";
                break;
            case 'expired':
                echo json_encode($obj->expiredReservation($_GET));
                // echo "Get All Users Requested";
                break;
            case 'delete':
                $id=$_GET['id'];
                echo json_encode($obj->deleteClass($id));
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