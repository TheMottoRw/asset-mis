<?php
session_start();
include('api_access.php');
?>
<html lang="en">

<?php include_once "includes/landing_header.php"; ?>

<body class="animsition">
<div class="page-wrapper">
    <div class="page-content--bge5">
        <div class="container">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">
                        <a href="#">
                            <!--                                <img src="images/icon/logo.png" alt="CoolAdmin">-->
                        </a>
                        <h3>IPRC TUMBA ASSET MANAGEMENT INFORMATION SYSTEM</h3>
                    </div>
                    <div class="login-form">
                        <?php
                        if (isset($_POST['btnLogin'])) {
                            $_POST['cate'] = 'login';
                            $respArr = curlPostRequest("HelperRequest.php", $_POST);
                            $resp = json_decode($respArr);
                            if ($resp->status == 'ok') {
                                $userInfo = $resp->user_info;
                                $_SESSION['login'] = true;
                                $_SESSION['user_info'] = ['firstname'=>$userInfo->firstname,'lastname'=>$userInfo->lastname,'email'=>$userInfo->email,'phone'=>$userInfo->phone];
                                $_SESSION['role'] = $userInfo->role;
                                $_SESSION['user_id'] = $userInfo->id;
                                if ($userInfo->role == 'Admin') {
                                    header('location:Departments.php');
                                } elseif ($userInfo->role == 'StockManager') {
                                    header('location:Assets.php');
                                } elseif ($userInfo->role == 'LabTechnician') {
                                    $_SESSION['department'] = $userInfo->dept_id;
                                    header('location:AssetMovements.php');
                                } elseif ($userInfo->role == 'Teacher') {
                                    $_SESSION['department'] = $userInfo->dept_id;
                                    header('location:Reservation.php');
                                } elseif ($userInfo->role == 'Student') {
                                    $_SESSION['department'] = $userInfo->dept_id;
                                    $_SESSION['class'] = $userInfo->class_id;
                                    header('location:Reservation.php');
                                } else {
                                    echo "<div class='alert alert-danger'> ".$userInfo->role." You are not authorized! </div>";
                                }
                            } else echo $resp->message;
                        }
                        ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label>Phone number or Email Address</label>
                                <input class="au-input au-input--full" type="text" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="au-input au-input--full" type="password" name="password"
                                       placeholder="Password">
                            </div>
                            <div class="login-checkbox">
                            </div>
                            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit" name="btnLogin">sign
                                in
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php include_once "includes/footer.php"; ?>
</body>

</html>
<!-- end document-->