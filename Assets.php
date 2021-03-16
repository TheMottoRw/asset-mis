<?php
session_start();
include('api_access.php');
$students = json_decode(curlGetRequest("StudentRequest.php?category=whotoborrow"));
$assets = json_decode(curlGetRequest("AssetsRequest.php?category=get"));
$departments = json_decode(curlGetRequest("DepartmentRequest.php?category=get"));

?>
<html lang="en">
<?php include_once "includes/logged_header.php";?>

<body class="animsition">
    <div class="page-wrapper">

        <!-- MENU SIDEBAR-->
        <?php include_once "includes/logged_menu_stockmgr.php";?>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <?php include_once "includes/logged_nav.php";?>
            <!-- END HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="container">
                        <h1>WELCOME TO ASSETS</h1>
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form">
                                +Add new Asset
                              </button>  
                            </div>

                            <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title" id="exampleModalLabel">Create new Asset</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form method="POST" id="form-asset" action="<?= $_SERVER['PHP_SELF']; ?>">
                                    <div class="modal-body">
										<form class="px-4 py-3 color-black" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
										  <div class="form-group">
										    <label for="names">Names</label>
                                              <input type="hidden" id="id" name="id" value="0">
										    <input type="text" class="form-control" id="names" name="names">
										  </div>
                                            <div class="form-group">
                                                <label for="serial_number">S/N</label>
                                                <input type="text" class="form-control" id="serial_number" name="serial_number">
                                            </div>
                                            <div class="form-group">
										    <label for="description">Description</label>
										    <input type="text" class="form-control" id="description" name="description">
										  </div>
										  <div class="form-group">
										    <label for="code">Local Code</label>
										    <input type="text" class="form-control" id="code" name="code">
										  </div>
										  <div class="form-group">
										    <label for="type">Type</label>
										    <input type="text" class="form-control" id="type" name="type">
										  </div>
                                            <div class="form-group">
                                                <label for="state">State</label>
                                                <select class="form-control" name="state" id="state">
                                                    <option>In use</option>
                                                    <option>In Stock</option>
                                                    <option>Damaged</option>
                                                    <option>Missing</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="departments">Department</label>
                                                <select class="form-control" name="departments" id="departments">
                                                    <?php
                                                    foreach ($departments as $k => $obj) {
                                                        ?>
                                                        <option value="<?= $obj->id; ?>"><?= $obj->names; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

										  <!-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> -->
										  <input type="submit" class="btn btn-primary btn-block mt-4" name="btnAdd" value="Add">
										</form>
                                    </div>
                                </div>
                              </div>
                            </div>
                <div id="response">
                    <?php
                    if(isset($_POST['btnAdd'])){
                        if($_POST['id']=='0')
                            $_POST['category'] = 'insert';
                        else $_POST['category'] = 'update';
                        $postData = array_merge($_POST,$_SESSION);
                        $response = json_decode(curlPostRequest("AssetsRequest.php",$postData));
                        echo $response->message;//."===".json_encode($response->error);
                    }
                    ?>
                </div>
	                        <table class="table table-borderless table-data3" id="data-asset">
	                            <thead>
	                                <tr>
	                                    <th>#</th>
	                                    <th>Names</th>
                                        <th>S/N</th>
                                        <th>Local code</th>
                                        <th>State</th>
                                        <th>Type</th>
                                        <th>Deparment</th>
                                        <th>Description</th>
	                                    <th colspan="2">Action</th>
	                                </tr>
	                            </thead>
	                            <tbody>
                                <?php
                                foreach ($assets as $k=>$obj){
                                    ?>
                                    <tr>
                                        <td><?= $k+1;?></td>
                                        <td><?= $obj->names;?></td>
                                        <td><?= $obj->serial_number;?></td>
                                        <td><?= $obj->code;?></td>
                                        <td><?= $obj->state;?></td>
                                        <td><?= $obj->type;?></td>
                                        <td><?= $obj->dep_name;?></td>
                                        <td><?= $obj->description;?></td>
                                        <td class="process">
                                            <button type="button" onclick='setEditAsset(<?php echo json_encode($obj);?>)' class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                            <button type="button" onclick="confirmDelete(<?= $obj->id;?>)" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
                                    </tr>
                                <?php } ?>
	                            </tbody>
	                        </table>
            <!-- END MAIN CONTENT-->
        </div>
        <!-- END PAGE CONTAINER-->
    </div>
        <!-- Stolen confirmation modal -->
        <button type="button" style="display: none" class="btn btn-info btn-xs" data-toggle="modal" data-target="#assetAssignModal" id="btnOpenAssetAssingModal">Open Modal</button>

        <!-- Modal -->
        <div id="assetAssignModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Assign asset  <b><span id="assetTitle"></span></b> to student or teacher</h4>
                        <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div id="stolenResponse"></div>
                        <form role="form" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                            <div class="form-group">
                                <input type="hidden" id="asset-id">
                                <label>Student</label>
                                <select class="form-control" name="student" id="student">
                                    <?php
                                    foreach ($students as $k=>$obj){
                                        ?>
                                    <option value="<?= $obj->email; ?>"><?= $obj->firstname." ".$obj->lastname . "[ ".$obj->email." ]";?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnAssignAsset" data-dismiss="modal">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
<button id="openmodal" data-toggle="modal" data-target="#form" style="display: none"></button>
        <?php include_once "includes/footer.php";?>

        <script>
            function setEditAsset(obj){
                $("#id").val(obj.id);
                $("#names").val(obj.names);
                $("#serial_number").val(obj.serial_number);
                $("#description").val(obj.description);
                $("#code").val(obj.code);
                $("#type").val(obj.type);
                document.getElementById("openmodal").click();
            }


            function confirmDelete(id) {
                var message = "Confirm class delete";

                var confirmation = confirm(message);
                if (confirmation) {
                    deleteDepartment(id);
                }
            }

            //function for book details
            function deleteDepartment(id) {
                $("#loaderIcon").show();
                jQuery.ajax({
                    url: "api/requests/AssetsRequest.php",
                    data: {category: 'delete', id: id},
                    type: "GET",
                    dataType: 'json',
                    success: function (data) {
                        $("#response").html(data.message);
                    },
                    error: function () {
                    }
                });
            }
            searchTable("#data-asset");

        </script>
</body>
</html>
<!-- end document-->
