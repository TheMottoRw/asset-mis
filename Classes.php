<?php
session_start();
include('api_access.php');
$departments = json_decode(curlGetRequest("DepartmentRequest.php?category=get"));
$classes = json_decode(curlGetRequest("ClassesRequest.php?category=get"));

?>

<html lang="en">
    <?php include_once "includes/logged_header.php";?>


<body class="animsition">
    <div class="page-wrapper">

        <!-- MENU SIDEBAR-->
        <?php include_once "includes/logged_menu.php";?>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <?php include_once "includes/logged_nav.php";?>
            <!-- END HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="container">
                        <h1>WELCOME TO CLASSES</h1>
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form">
                                +Add new Class
                              </button>  
                            </div>

                            <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title" id="exampleModalLabel">Create new Class</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                    <div class="modal-body">
										<form class="px-4 py-3 color-black" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
										  <div class="form-group">
										    <label for="name">Name</label>
										    <input type="text" class="form-control" id="name" name="name">
										  </div>
                                            <div class="form-group">
                                                <label for="department">Department</label>
                                                <select class="form-control" id="department" name="department">
                                                    <?php
                                                    foreach ($departments as $k=>$obj){
                                                        ?>
                                                        <option value="<?= $obj->id; ?>"><?= $obj->names; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                    ?>
                                                </select>
                                            </div>
										  <div class="form-group">
										    <label for="academic_year">Academic Year</label>
										    <input type="text" class="form-control" id="academic_year" name="academic_year">
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
                        $_POST['category'] = 'insert';
                        $postData = array_merge($_POST,$_SESSION);
                        $response = json_decode(curlPostRequest("ClassesRequest.php",$postData));
                        echo $response->message;
                    }
                    ?>
                </div>
                            <table class="table table-borderless table-data3">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Department</th>
                                        <th>Name</th>
                                        <th>Academic year</th>
                                        <th>Registered on</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($classes as $k=>$obj){
                                    ?>
                                    <tr>
                                        <td><?= $k+1;?></td>
                                        <td><?= $obj->dep_name;?></td>
                                        <td><?= $obj->name;?></td>
                                        <td><?= $obj->academic_year;?></td>
                                        <td><?= substr($obj->registered_on,0,10);?></td>
                                        <td class="process">
                                            <a href="#" class="btn btn-edit"><i class="fa fa-edit"></i></a>
                                            <button type="button" onclick="confirmDelete(<?= $obj->id;?>)" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
            <!-- END MAIN CONTENT-->
        </div>
        <!-- END PAGE CONTAINER-->

    </div>

        <?php include_once "includes/footer.php";?>

        <script>
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
                    url: "api/requests/ClassesRequest.php",
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
        </script>
</body>

</html>
<!-- end document-->
