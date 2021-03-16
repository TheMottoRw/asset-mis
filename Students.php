<?php
session_start();
include('api_access.php');
$departments = json_decode(curlGetRequest("DepartmentRequest.php?category=get"));
$classes = json_decode(curlGetRequest("ClassesRequest.php?category=get"));
$students = json_decode(curlGetRequest("StudentRequest.php?category=get"));

?>
<html lang="en">
<?php include_once "includes/logged_header.php"; ?>

<body class="animsition">
<div class="page-wrapper">
    <!-- MENU SIDEBAR-->
    <?php include_once "includes/logged_menu_labtech.php"; ?>
    <!-- END MENU SIDEBAR-->

    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <?php include_once "includes/logged_nav.php"; ?>
        <!-- END HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="container">
                <h1>WELCOME TO STUDENTS</h1>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form">
                    +Add new Student
                </button>
            </div>

            <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title" id="exampleModalLabel">Create new Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="px-4 py-3 color-black"
                                  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                <div class="form-group">
                                    <label for="firstname">Firstname</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname">
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Lastname</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname">
                                </div>
                                <div class="form-group">
                                    <label for="reg_number">Registration number</label>
                                    <input type="text" class="form-control" id="reg_number"
                                           name="reg_number">
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
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password"
                                           name="password">
                                </div>
                                <div class="form-group">
                                    <label>Department Of Student</label>
                                    <select name="dept_id" onchange="loadClassByDepartment(this.value)" class="form-control select2" style="width: 100%;">
                                        <option selected="selected" disabled="disabled">-- Select Department--</option>
                                        <?php foreach ($departments AS $i=>$obj) { ?>
                                            <option value="<?= $obj->id; ?>"><?= $obj->names; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Class Of Student</label>
                                    <select name="class_id" id="class_id" class="form-control select2" style="width: 100%;">
                                        <option selected="selected" disabled="disabled">-- Select Class--</option>
                                        <?php foreach ($classes as $k=>$obj) { ?>
                                            <option value="<?= $obj->id; ?>"><?= $obj->name; ?></option>
                                        <?php } ?>
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
                    $_POST['category'] = 'insert';
                    $postData = array_merge($_POST,$_SESSION);
                    $response = json_decode(curlPostRequest("StudentRequest.php",$postData));
                    echo $response->message;
                }
                ?>
            </div>
            <table class="table table-borderless table-data3" id="data-students">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Names</th>
                    <th>Reg Number</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Class</th>
                    <th colspan="2">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($students as $k=>$obj){
                    ?>
                    <tr>
                        <td><?= $k+1;?></td>
                        <td><?= $obj->firstname." ".$obj->lastname;?></td>
                        <td><?= $obj->reg_number;?></td>
                        <td><?= $obj->email;?></td>
                        <td><?= $obj->phone;?></td>
                        <td><?= $obj->dep_name;?></td>
                        <td><?= $obj->class_name;?></td>
                        <td>
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
                url: "api/requests/StudentRequest.php",
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
            //function for book details
            function loadClassByDepartment(departmentid) {
                $("#loaderIcon").show();
                var classes = "<option value=0 disabled=disabled>--Select class--</option>";
                jQuery.ajax({
                    url: "api/requests/ClassesRequest.php",
                    data: {category: 'getbydepartment', department: departmentid},
                    type: "GET",
                    dataType: 'json',
                    success: function (data) {
                        for(var i=0;i<data.length;i++){
                            classes+="<option value='"+data[i].id+"'>"+data[i].name+"</option>";
                        }
                        document.getElementById('class_id').innerHTML = classes;
                    },
                    error: function () {
                    }
                });
        }
        searchTable("#data-students");
    </script>
</body>

</html>
<!-- end document-->
