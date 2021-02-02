<?php include("../Student.php"); 
include("../Department.php"); 
include("../Classes.php"); 
$student=new Student;
$student->connect();

$department = new Department;
$department->connect();
$dept = $department->getAllDepartments();

$classes = new Classes;
$classes->connect();
$classe = $classes->getAllClasses();
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
                    <a href="ClassInsert.php" class="nav-link">Classes</a>
                </li>
                <li class="nav-item">
                    <a href="DepartmentInsert.php" class="nav-link">Department</a>
                </li>
                <li class="nav-item">
                    <a href="EmployeeInsert.php" class="nav-link">Employees</a>
                </li>
                <li class="nav-item">
                    <a href="StudentInsert.php" class="nav-link active">Students</a>
                </li>
            </ul>
        </div>
    </nav>
    </div>
  <div class="col-lg-6 col-md-6 sm-12 bg-secondary m-5">
    <h1>INSERT STUDENT</h1>
<form class="px-4 py-3 color-black" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Firstname</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="firstname">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Lastname</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="lastname">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">reg_number</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="reg_number">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">E-mail</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
  </div> 
  <div class="form-group">
    <label for="exampleInputPassword1">Type</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="type">
  </div>
  <div class="form-group">
  <label>Department Of Student</label>
    <select name="dept_id" class="form-control select2" style="width: 100%;">
    <option selected="selected" disabled="disabled">-- Select Department--</option>
    <?php for ($i=0; $i < count($dept); $i++) { ?>
      <option value="<?= $dept[$i]['id']; ?>"><?= $dept[$i]['names']; ?></option>
    <?php } ?>
  </select>
  </div>
  <div class="form-group">
  <label>Class Of Student</label>
    <select name="class_id" class="form-control select2" style="width: 100%;">
    <option selected="selected" disabled="disabled">-- Select Class--</option>
    <?php for ($i=0; $i < count($classe); $i++) { ?>
      <option value="<?= $classe[$i]['id']; ?>"><?= $classe[$i]['name']; ?></option>
    <?php } ?>
  </select>
  </div>
  <!-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> -->
  <input type="submit" class="btn btn-primary btn-block mt-4" value="Add">
</form>
</div>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $firstname=$_POST['firstname'];
  $lastname=$_POST['lastname'];
  $reg_number=$_POST['reg_number'];
  $email=$_POST['email'];
  $password=$_POST['password'];
  $dept_id=$_POST['dept_id'];
  $class_id=$_POST['class_id'];

$student->insertStudent($firstname,$lastname,$reg_number,$email,$password,$dept_id,$class_id);
}
?>
</body>
</html>

