<?php 
include_once "Database.php";
include_once "Validator.php";

class Student
{
    private $conn;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getInstance();
        $this->validate = new Validator();
    }

	function insertStudent($arr){

	$response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Successfully student registered</div>", 'id' => 0];
	
    $firstname = $arr['firstname'];
    $lastname = $arr['lastname'];
    $reg_number = $arr['reg_number'];
    $email = $arr['email'];
    $password = base64_encode($arr['password']);
    $phone = $arr['phone'];
    $dept_id = $arr['dept_id'];
    $class_id = $arr['class_id'];

        // validation
        $validationStatus = $this->validate->isEmpty(["Firstname"=>$firstname,"Lastname"=>$lastname,"Registration number"=>$reg_number,"Phone"=>$phone,"Email"=>$email]);
        if($validationStatus['status']){
            return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        }
        if(!$this->validate->phone("rwandan",$phone)) return ['status'=>'ok','message'=>"<div class='alert alert-danger'>Invalid phone number</div>"];
        if(!$this->validate->email($email)) return ['status'=>'ok','message'=>"<div class='alert alert-danger'>Invalid email address</div>"];
        // end validation

	$query=$this->conn->prepare("INSERT INTO student set firstname =:firstname,lastname=:lastname,reg_number=:reg_number,email=:email,phone=:phone,password=:password,dept_id=:dept_id,class_id=:class_id");

	$query->execute(array("firstname"=>$firstname,"lastname"=>$lastname,"reg_number"=>$reg_number,"email"=>$email,"phone"=>$phone,"password"=>$password,"dept_id"=>$dept_id,"class_id"=>$class_id));

    if ($query->rowCount()>0) {
    	   $response['id'] = $this->conn->lastInsertId();
        } else {
            $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to add student</div>", 'error' => $query->errorInfo()];
        }
        return $response;
    }

	function getAllStudents(){
		header("Content-Type:application");
		$query=$this->conn->query("SELECT s.*,c.name as class_name,d.names as dep_name FROM student s INNER JOIN department d ON d.id=s.dept_id INNER JOIN classes c ON c.id=s.class_id");
		$data=$query->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}
	function getStudentById($id){
		$query=$this->conn->prepare("SELECT * FROM student where id=:id");
		$query->execute(array("id"=>$id));
		$data=$query->fetchAll(PDO::FETCH_ASSOC);
		if ($query->rowCount()==0) {
			return [];
		}
		return $data;
	}
	function getWhoToBorrow(){
        $qy = $this->conn->prepare("SELECT *,'' as class_id FROM employee UNION SELECT * FROM student");
        $qy->execute();
        return $qy->fetchAll(PDO::FETCH_ASSOC);
    }
	function deleteStudent($id){

		$response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Successfully deleted Student</div>", 'id' => $id];

		$query=$this->conn->prepare("DELETE FROM student WHERE id=:id");
		$query->execute(array("id"=>$id));
		if ($query->rowCount()==0) {
			$response = ['status' => 'fail', 'message' => "Failed to delete", 'id' => $id, "error" => $query->errorInfo()];
        }
        return $response;
    }
	function updateStudent($arr){

	$response = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Student succesful updated</div>", 'id' => $arr['id']];

    $firstname = $arr['firstname'];
    $lastname = $arr['lastname'];
    $reg_number = $arr['reg_number'];
    $email = $arr['email'];
    $phone = $arr['phone'];
    $dept_id = $arr['dept_id'];
    $class_id = $arr['class_id'];
    $id = $arr['id'];

        // validation
        $validationStatus = $this->validate->isEmpty(["Firstname"=>$firstname,"Lastname"=>$lastname,"Registration number"=>$reg_number,"Phone"=>$phone,"Email"=>$email]);
        if($validationStatus['status']){
            return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        }
        if(!$this->validate->phone("rwandan",$phone)) return ['status'=>'fail','message'=>"<div class='alert alert-danger'>Invalid phone number</div>"];
        if(!$this->validate->email($email)) return ['status'=>'fail','message'=>"<div class='alert alert-danger'>Invalid email address</div>"];
        // end validation


        $query=$this->conn->prepare("UPDATE student set firstname =:firstname,lastname=:lastname,reg_number=:reg_number,email=:email,dept_id=:dept_id,class_id=:class_id WHERE id=:id");


	$query->execute(array("firstname"=>$firstname,"lastname"=>$lastname,"reg_number"=>$reg_number,"email"=>$email,"dept_id"=>$dept_id,"class_id"=>$class_id,"id"=>$id));
		if ($query->rowCount()==0) {
	    $response = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to update student</div>", 'id' => $id, 'error' => $query->errorInfo()];
        }
        return $response;
    }
}
?>