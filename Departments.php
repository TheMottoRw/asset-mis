<?php
session_start();
include('api_access.php');
//echo $_SESSION['user_info']->firstname;
$resp = json_decode(curlGetRequest("DepartmentRequest.php?category=get"));

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
                        <h1>WELCOME TO DEPARTMENTS</h1>
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form">
                                +Add new Department
                              </button>  
                            </div>

                            <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title" id="exampleModalLabel">Create new Department</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                    <div class="modal-body">
                                        <form class="px-4 py-3 color-black" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                            <div class="form-group">
                                                <label for="names">Department name</label>
                                                <input type="text" class="form-control" id="names" name="names">
                                            </div>
                                          <div class="form-group">
                                            <label for="acronym">Acronym</label>
                                            <input type="text" class="form-control" id="acronym" name="acronym">
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
                    $response = json_decode(curlPostRequest("DepartmentRequest.php",$postData));
                    echo $response->message;
                }
                ?>
                </div>
                            <table class="table table-borderless table-data3" id="data-departments">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Acronym</th>
                                        <th>Names</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($resp as $k=>$obj){
                                ?>
                                    <tr>
                                        <td><?= $k+1;?></td>
                                        <td><?= $obj->acronym;?></td>
                                        <td><?= $obj->names;?></td>
                                        <td class="process">
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
      var message = "Confirm department delete";

        var confirmation = confirm(message);
        if (confirmation) {
            deleteDepartment(id);
        }
    }

    //function for book details
    function deleteDepartment(id) {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "api/requests/DepartmentRequest.php",
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
    searchTable("#data-departments");
</script>
</body>

</html>
<!-- end document-->
