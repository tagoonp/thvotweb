<?php
require("../../database_config/thvot/config.inc.php");
require('./configuration/configuration.php');
require('./configuration/database.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <title>ระบบติดตามการรับประทานยา :: TH-VOT</title>

    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">

    
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo filemtime('./assets/css/style.css'); ?>" type="text/css">
    <link rel="stylesheet" href="./node_modules/fontawesome/css/all.min.css" >
</head>
<body>

    <div class="main-content pl-4 pr-4">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 offset-sm-3">

                <nav class="navbar navbar-light pl-0 pr-0 pb-4 pt-4">
                        <a class="navbar-brand" href="./">
                            <img src="https://thvot.com/img/thvot-web-logo.png" width="120" alt="">
                        </a>
                    </nav>
                    
                    <a href="#" class="text-dark">
                        <i class="fas fa-chevron-left"></i> กลับหน้าหลัก
                    </a>

                    <div class="row pt-4">
                        <div class="col-12">
                            <h1 class="mb-0">เข้าสู่ระบบ</h1>
                            <h4 class="text-muted">Login</h4>
                        </div>
                        <div class="col-12 pt-3">
                            <form action="./controller/authen.php?stage=1" onsubmit="return checkLogin();" method="post">
                                <div class="form-group">
                                    <label for="">ชื่อบัญชีผู้ใช้งาน : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" require id="txtUsername" name="txtUsername" autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="">รหัสผ่าน : <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" require id="txtPassword" name="txtPassword">
                                </div>
                                <div class="form-group pt-3">
                                    <button class="btn btn-primary th200" type="submit">ลงชื่อเข้าใช้งาน</button>
                                    <a href="register.php" class="float-right text-muted">สมัครใช้งานระบบ</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function(){

        })

        function checkLogin(){
            $check = 0
            $('.form-control').removeClass('is-invalid')
            if($('#txtUsername').val() == ''){
                $('#txtUsername').addClass('is-invalid')
                $check++;
            }
            if($('#txtPassword').val() == ''){
                $('#txtPassword').addClass('is-invalid')
                $check++;
            }
            if($check != 0){
                return false;
            }
        }
    </script>
</body>
</html>