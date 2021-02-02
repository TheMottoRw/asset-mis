<?php include("../Classes.php"); 
$classes=new Classes;
$classes->connect();
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
                    <a href="AssetMovementInsert.php" class="nav-link">Assets Movements</a>
                </li>
                <li class="nav-item">
                    <a href="ClassInsert.php" class="nav-link active">Classes</a>
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
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="name">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Academic Year</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="academic_year">
  </div>
  
  <!-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> -->
  <input type="submit" class="btn btn-primary btn-block mt-4" value="Add">
</form>
</div>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $name=$_POST['name'];
  $academic_year=$_POST['academic_year'];

$classes->insertClass($name,$academic_year);
}
?>
</body>
</html>

