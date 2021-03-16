<?php
session_start();
include('api_access.php');
$reserved = json_decode(curlGetRequest("ReservationRequest.php?category=byuser&user_id=".$_SESSION['user_id']."&role=".$_SESSION['role']));
$assets = json_decode(curlGetRequest("AssetsRequest.php?category=available"));

?>
<!DOCTYPE html>
<html lang="en">
<?php include_once "includes/logged_header.php";?>

<body class="animsition">
<div class="page-wrapper">

    <?php include_once "includes/logged_menu_emp.php";?>

    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <?php include_once "includes/logged_nav.php";?>
        <!-- END HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="container">
                <h1>WELCOME TO ASSET RESERVATION</h1>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form">
                    + Reserve an asset
                </button>
            </div>
            <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title" id="exampleModalLabel">Reserve an Asset</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                                <div class="form-group">
                                    <label>Asset</label>
                                    <select name="asset_id" class="form-control select2" style="width: 100%;">
                                        <option selected="selected" disabled="disabled">-- Select Assets--</option>
                                        <?php foreach ($assets as $k => $asset) { ?>
                                            <option value="<?= $asset->id; ?>"><?= $asset->names . " [" . $asset->code . "]"; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control" id="location" name="location">
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="text" class="form-control" id="quantity" name="quantity">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="btnRegister" class="btn btn-primary" >Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php

            if (isset($_POST['btnRegister'])) {

                $postData = array_merge($_POST, $_SESSION, ['category' => 'insert']);
//                echo json_encode($postData);
                $response = curlPostRequest("ReservationRequest.php", $postData);
//                echo $response;
                $resp = json_decode($response);
                echo $resp->message;//." == ".$resp->id." == ".json_encode($resp->error);
            }
            ?>
            <div id="response"></div>
            <table class="table table-borderless table-data3" id="data-reservations">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Names</th>
                    <th>S/N</th>
                    <th>Local code</th>
                    <th>State</th>
                    <th>Type</th>
                    <th colspan="2">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($reserved as $k=>$obj){
                    ?>
                    <tr>
                        <td><?= $k+1;?></td>
                        <td><?= $obj->names;?></td>
                        <td><?= $obj->serial_number;?></td>
                        <td><?= $obj->code;?></td>
                        <td><?= $obj->state;?></td>
                        <td><?= $obj->type;?></td>
                        <td class="process">
                            <button type="button" onclick="setReserveAsset(<?= $obj->id;?>)" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <!-- END MAIN CONTENT-->
        </div>
        <!-- END PAGE CONTAINER-->

    </div>

    <?php include_once "includes/footer.php";?>

</body>

</html>
<script>
    function setReserve(asset){
        var quantity = prompt("Please enter your name");
        if(quantity==null || quantity==0 || isNaN(quantity)) alert("Quantity should be a number greater than 0");
        else{
            console.log("asset id "+asset+" quantity "+quantity );
            // jQuery.ajax({
            //     url: "api/requests/AssetsRequest.php",
            //     data: {category: 'register', assetid: asset,quantity:quantity},
            //     type: "GET",
            //     dataType: 'json',
            //     success: function (data) {
            //         $("#response").html(data.message);
            //     },
            //     error: function () {
            //     }
            // });
        }
    }
    searchTable("#data-reservations");
</script>
<!-- end document-->
