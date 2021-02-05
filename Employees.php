<?php
session_start();
include('api_access.php');
$departments = json_decode(curlGetRequest("DepartmentRequest.php?category=get"));
$employees = json_decode(curlGetRequest("EmployeeRequest.php?category=get"));

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
                        <h1>WELCOME TO EMPLOYEES</h1>
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form">
                                +Add new Employee
                              </button>  
                            </div>

                            <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title" id="exampleModalLabel">Create new Employee</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                    <div class="modal-body">
                                        <form class="px-4 py-3 color-black" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                          <div class="form-group">
                                            <label for="firstname">Firstname</label>
                                            <input type="text" class="form-control" id="firstname" name="firstname">
                                          </div>
                                          <div class="form-group">
                                            <label for="lastname">Lastname</label>
                                            <input type="text" class="form-control" id="lastname" name="lastname">
                                          </div>
                                          <div class="form-group">
                                            <label for="email">E-mail</label>
                                            <input type="text" class="form-control" id="email" name="email">
                                          </div>
                                          <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone">
                                          </div>
                                          <div class="form-group">
                                            <label for="role">Role</label>
                                              <select class="form-control" id="role" name="role">
                                                  <option>Admin</option>
                                                  <option>Standard</option>
                                              </select>
                                          </div>

                                            <div class="form-group">
                                                <label for="dept_id">Department</label>
                                                <select class="form-control" id="dept_id" name="dept_id">
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
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password">
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
                        $response = json_decode(curlPostRequest("EmployeeRequest.php",$postData));
                        echo $response->message;
                    }
                    ?>
                </div>
                            <table class="table table-borderless table-data3">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Names</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Department</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($employees as $k=>$obj){
                                    ?>
                                    <tr>
                                        <td><?= $k+1;?></td>
                                        <td><?= $obj->firstname." ".$obj->lastname;?></td>
                                        <td><?= $obj->email;?></td>
                                        <td><?= $obj->phone;?></td>
                                        <td><?= $obj->role;?></td>
                                        <td><?= $obj->dep_name;?></td>
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
                    url: "api/requests/EmployeeRequest.php",
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
