<!DOCTYPE html>
<html lang="en">
<?php include_once "includes/logged_header.php";?>

<body class="animsition">
<div class="page-wrapper">

    <?php include_once "includes/logged_menu.php";?>

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
                    +Add new Asset Movement
                </button>
            </div>

            <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title" id="exampleModalLabel">Reserve an asset for 5 minute</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form>
                            <div class="modal-body">
                                <form class="px-4 py-3 color-black" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                    <div class="form-group">
                                        <label>Student</label>
                                        <select name="student_id" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" disabled="disabled">-- Select Student--</option>
                                            <?php for ($i=0; $i < count($students1); $i++) { ?>
                                                <option value="<?= $students1[$i]['id']; ?>"><?= $students1[$i]['firstname']; ?> <?= $students1[$i]['lastname']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Department Of Asset</label>
                                        <select name="asset_id" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" disabled="disabled">-- Select Department--</option>
                                            <?php for ($i=0; $i < count($assets1); $i++) { ?>
                                                <option value="<?= $assets1[$i]['id']; ?>"><?= $assets1[$i]['names']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="booked_on">Booked on</label>
                                        <input type="text" class="form-control" id="booked_on" name="booked_on" placeholder="YYYY-MM-DD HH:MM:SS">
                                    </div>
                                    <div class="form-group">
                                        <label for="submitted_on">Submitter On</label>
                                        <input type="text" class="form-control" id="submitted_on" name="submitted_on" placeholder="YYYY-MM-DD HH:MM:SS">
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="text" class="form-control" id="quantity" name="quantity">
                                    </div>
                                    <!-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> -->
                                    <input type="submit" class="btn btn-primary btn-block" value="Add">
                                </form>
                            </div>
                    </div>
                </div>
            </div>

            <table class="table table-borderless table-data3">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Asset Names</th>
                    <th>Asset S/N</th>
                    <th>Booked on</th>
                    <th>Given on</th>
                    <th>Submitted on</th>
                    <th>Status</th>
                    <th>Quantity</th>
                    <th colspan="2">Action</th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <td>1</td>
                    <td>Hanyurwimfura Dieudonne</td>
                    <td>VGA</td>
                    <td>VG01-HP</td>
                    <td>12</td>
                    <td>2020-10-11</td>
                    <td>2019-11-12</td>
                    <td class="process">2021-12-12</td>
                    <td class="process">Usable</td>
                    <td class="process">Edit</td>
                    <td class="denied">Delete</td>
                </tr>
                </tbody>
            </table>
            <!-- END MAIN CONTENT-->
        </div>
        <!-- END PAGE CONTAINER-->

    </div>

    <?php include_once "includes/footer.php";?>

</body>

</html>
<!-- end document-->
