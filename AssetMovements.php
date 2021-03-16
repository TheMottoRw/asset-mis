<?php
session_start();
include('api_access.php');
$students = json_decode(curlGetRequest("StudentRequest.php?category=whotoborrow"));
$assets = json_decode(curlGetRequest("AssetsRequest.php?category=available&department=" . $_SESSION['department']));
$movements = json_decode(curlGetRequest("AssetMovementRequest.php?category=get&department=" . $_SESSION['department']));

?>
<html lang="en">
<?php include_once "includes/logged_header.php"; ?>

<body class="animsition">
<div class="page-wrapper">

    <?php include_once "includes/logged_menu_labtech.php"; ?>

    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <?php include_once "includes/logged_nav.php"; ?>
        <!-- END HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="container">
                <h1>WELCOME TO ASSET MOVEMENTS</h1>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form">
                    +Add new Asset Movement
                </button>
            </div>

            <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title" id="exampleModalLabel">Create new Asset Movement</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                                <div class="form-group">
                                    <label>Student</label>
                                    <select name="student_id" name="student_id" class="form-control select2"
                                            style="width: 100%;">
                                        <option selected="selected" disabled="disabled">-- Select student or teacher--
                                        </option>
                                        <?php foreach ($students as $k => $student) { ?>
                                            <option value="<?= $student->email; ?>"><?= $student->firstname . " " . $student->lastname . " [" . $student->email . "]"; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
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
                                    <label for="booked_on">Booked on</label>
                                    <input type="date" class="form-control" id="booked_on" name="booked_on"
                                           placeholder="YYYY-MM-DD HH:MM:SS">
                                </div>
                                <div class="form-group">
                                    <label for="submitted_on">Submitter On</label>
                                    <input type="date" class="form-control" id="submitted_on" name="submitted_on"
                                           placeholder="YYYY-MM-DD HH:MM:SS">
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
                $response = curlPostRequest("AssetMovementRequest.php", $postData);
//                echo $response;
                $resp = json_decode($response);
                echo $resp->message;//." == ".$resp->id." == ".json_encode($resp->error);
            }
            ?>
            <div id="response"></div>
            <table class="table table-borderless table-data3" id="asset-movements">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Given to</th>
                    <th>Type</th>
                    <th>Asset Names</th>
                    <th>Asset S/N</th>
                    <th>Quantity</th>
                    <th>Given on</th>
                    <th>Submitted on</th>
                    <th>Given by</th>
                    <th>Status</th>
                    <th colspan="2">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($movements as $k =>$movement) {
                 ?>
                    <tr>
                        <td><?= $k+1;?></td>
                        <td><?=$movement->lend_to; ?></td>
                        <td><?=$movement->student_id==0?"Teacher":"Student"; ?></td>
                        <td><?=$movement->names; ?></td>
                        <td><?=$movement->serial_number; ?></td>
                        <td><?=$movement->quantity; ?></td>
                        <td><?=$movement->given_on==null?substr($movement->booked_on,0,16):substr($movement->given_on,0,16); ?></td>
                        <td><?=$movement->submitted_on==null?"<button class='btn btn-sm btn-warning'>Not yet returned</button>":$movement->submitted_on; ?></td>
                        <td><?= $movement->given_by; ?></td>
                        <td><?= $movement->status; ?></td>
                        <td colspan="2"><?= $movement->submitted_on==null?"<button class='btn btn-sm btn-success' onclick='confirmSubmit($movement->id)'><i class='fa fa-share'></i> Submit </button>":"Submitted";?></td>
                    </tr>
                 <?php
                }
                ?>
                </tbody>
            </table>
            <!-- END MAIN CONTENT-->
        </div>
        <!-- END PAGE CONTAINER-->

    </div>

    <?php include_once "includes/footer.php"; ?>
    <script>
        var d = new Date(),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        var today = [year, month, day].join('-');

        document.getElementById('booked_on').setAttribute('min', today);
        document.getElementById('submitted_on').setAttribute('min', today);

        function confirmSubmit(id){
            var confSub = confirm("Are you sure asset has been submitted");
            if(confSub){
                jQuery.ajax({
                    url: "api/requests/AssetMovementRequest.php",
                    data: {category: 'return', id: id},
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $("#response").html(data.message);
                    },
                    error: function () {
                    }
                });
            }
        }
        searchTable("#asset-movements");
    </script>
</body>
</html>
<!-- end document-->
