<?php include("../Assets.php"); 
include("../Department.php"); 
$assets=new Assets;
$assets->connect();
$department = new Department;
$department->connect();
$dept = $department->getAllDepartments();
$assets->getAllAssets();
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
                    <a href="AssetInsert.php" class="nav-link active" >Assets</a>
                </li>
                <li class="nav-item">
                    <a href="AssetMovementInsert.php" class="nav-link">Assets Movements</a>
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
    <h1>INSERT ASSET</h1>
<form class="px-4 py-3 color-black" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Names</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="names">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">State</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="state">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Description</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="description">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Code</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="code">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">S/N</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="serial_number">
  </div> 
  <div class="form-group">
    <label for="exampleInputPassword1">Type</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="type">
  </div>
  <label>Department Of Asset</label>
    <select name="dept_id" class="form-control select2" style="width: 100%;">
    <option selected="selected" disabled="disabled">-- Select Department--</option>
    <?php for ($i=0; $i < count($dept); $i++) { ?>
      <option value="<?= $dept[$i]['id']; ?>"><?= $dept[$i]['names']; ?></option>
    <?php } ?>
  </select>
  
  <!-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> -->
  <input type="submit" class="btn btn-primary btn-block mt-4" value="Add">
</form>
</div>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $names=$_POST['names'];
  $state=$_POST['state'];
  $description=$_POST['description'];
  $code=$_POST['code'];
  $serial_number=$_POST['serial_number'];
  $type=$_POST['type'];
  $dept_id=$_POST['dept_id'];

$assets->insertAsset($names,$state,$description,$code,$serial_number,$type,$dept_id );
}
?>
</body>
</html>

