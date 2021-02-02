<?php include("../AssetMovement.php"); 
include("../Student.php"); 
include("../Assets.php"); 
$assetMovement=new AssetMovement;
$assetMovement->connect();

$students = new Student;
$students->connect();
$students1=$students->getAllStudents();

$assets=new Assets;
$assets->connect();
$assets1 =$assets->getAllAssets();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Insert Asset</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="bs-example">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark mx-5 py-4">
        <a href="#" class="navbar-brand font-weight-bold display-3">SCHOOL ASSETS MANAGEMENT SYSTEM</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a href="AssetInsert.php" class="nav-link" >Assets</a>
                </li>
                <li class="nav-item">
                    <a href="AssetMovementInsert.php" class="nav-link active">Assets Movements</a>
                </li>
                <li class="nav-item">
                    <a href="ClassInsert.php" class="nav-link">Classes</a>
                </li>
                <li class="nav-item">
                    <a href="DepartmentInsert.php" class="nav-link">Department</a>
                </li>
                <li class="nav-item">
                    <a href="EmployeeInsert.php" class="nav-link">Employees</a>
                </li>
                <li class="nav-item">
                    <a href="StudentInsert.php" class="nav-link">Students</a>
                </li>
            </ul>
        </div>
    </nav>
    </div>
  <div class="col-lg-6 col-md-6 sm-12 bg-secondary m-5">
    <h1>INSERT ASSET-MOVEMENT</h1>
<form class="px-4 py-3 color-black" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
    <label for="exampleInputEmail1">Booked on</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="booked_on" placeholder="YYYY-MM-DD HH:MM:SS">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Submitter On</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="submitted_on" placeholder="YYYY-MM-DD HH:MM:SS">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Location</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="location">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Status</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="status">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Quantity</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="quantity">
  </div> 
  <!-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> -->
  <input type="submit" class="btn btn-primary btn-block" value="Add">
</form>
</div>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $student_id=$_POST['student_id'];
  $asset_id=$_POST['asset_id'];
  $booked_on=$_POST['booked_on'];
  $submitted_on=$_POST['submitted_on'];
  $location=$_POST['location'];
  $status=$_POST['status'];
  $quantity=$_POST['quantity'];

$assetMovement->insertAssetMovement($student_id,$asset_id,$booked_on,$submitted_on,$location,$status,$quantity);
}
?>
</body>
</html>

