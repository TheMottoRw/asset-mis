<?php
include_once "Database.php";
class Helper{
    function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getInstance();
    }
    function adminExistance(){
        $qy = $this->conn->prepare("SELECT * FROM employee WHERE role='Admin'");
        $qy->execute();
        if($qy->rowCount()==0){
            $qy = $this->conn->prepare("INSERT INTO employee SET firstname=:fname,lastname=:lname,email=:email,phone=:phone,role=:role,dept_id=:dept,password=:pwd");
            $qy->execute(['fname'=>'Gad','lname'=>'Ishimwe','email'=>'gad@gmail.com','phone'=>'0726183050','role'=>'Admin','dept'=>1,'pwd'=>base64_encode(12345)]);
            if($qy->rowCount() ==0){
                echo json_encode($qy->errorInfo());
                exit;
            }
        }
    }
    public function login($datas){
//        return $datas;
        $this->adminExistance();
        $response = ['status'=>'ok','data'=>[],'message'=>"<div class='alert alert-success'>Successful logged in</div>"];
        $qy = $this->conn->prepare("SELECT * FROM employee WHERE (phone=:phone OR email=:phone) AND password=:pwd");
        $qy->execute(['phone'=>$datas['email'],'pwd'=>base64_encode($datas['password'])]);
        if($qy->rowCount()==1){//success
            $response['user_info'] = $qy->fetchAll(PDO::FETCH_ASSOC)[0];
        }else{//check resident
            $qyResident = $this->conn->prepare("SELECT * FROM students WHERE (reg_number=:phone OR phone=:phone OR email=:phone) AND password=:pwd");
            $qyResident->execute(['phone'=>$datas['email'],'pwd'=>base64_encode($datas['password'])]);
            if($qyResident->rowCount()==1){//success
                $response['user_info'] = $qyResident->fetchAll(PDO::FETCH_ASSOC)[0];
                $response['user_info']['role'] = 'Student';
            }else{
                $response['status'] = 'fail';
                $response['message'] = "<div class='alert alert-danger'>Wrong credential provided</div>";
            }
        }
        return $response;
    }
}
?>