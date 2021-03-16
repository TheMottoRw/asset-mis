<?php
function curlPostRequest($page,$dataArr){
    $url = 'http://localhost/TCT/assets/api/requests/';
    $url.=$page;
   //create name value pairs seperated by &
   
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type"=>"application/json"));
//    curl_setopt($ch, CURLOPT_HTTPHEADER,false);
    curl_setopt($ch, CURLOPT_POST, count($_POST));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataArr);
 
    $output=curl_exec($ch);

    curl_close($ch);
    return $output;
}
function curlGetRequest($page){
    $url = 'http://localhost/TCT/assets/api/requests/';
    $url.=$page;
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type"=>"application/json"));
 
    $output=curl_exec($ch);
 
    curl_close($ch);
    return $output;
}
function setSession($arr){
    foreach ($arr as $key=>$val){
        $_SESSION[$key] = $val;
    }
}
function validateSession($allowedSession){
    $currentFile = basename($_SERVER['PHP_SELF']);
    $dualPrivileged = [];
    if(!isset($_SESSION['login'])) header("location:login.php");
    else {
        //validate privileges
        if(!in_array($currentFile,$dualPrivileged)){
            //check allowed privilege
            if(!in_array($_SESSION['role'],$allowedSession)){
                session_destroy();
                echo "<script>window.location='login.php';</script>";
//                header("location:signin.php");
            }
        }
    }
}
function sessionsToGetParams(){
    $data = "";
    foreach ($_SESSION as $k=>$v){
        $v = str_replace(" ","%20",$v);
        if($data!="") $data.="&".$k."=".$v;
        else $data = $k."=".$v;
    }
    return $data;
}
?>