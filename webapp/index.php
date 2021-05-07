<?php
require("../../database_config/thvot/config.inc.php");
require('../configuration/configuration.php');
require('../configuration/database.php'); 
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

    <div class="header pt-2 pb-2">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 offset-sm-3 pl-0 pt-3 pr-0">
                    <nav class="navbar navbar-light">
                        <a class="navbar-brand" href="./">
                            <img src="https://thvot.com/img/thvot-web-logo.png" width="120" alt="">
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 offset-sm-3">
                    
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
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">รหัสผ่าน : <span class="text-danger">*</span></label>
                                    <input type="password]" class="form-control">
                                </div>
                                <div class="form-group pt-3">
                                    <button class="btn btn-success th200">ลงชื่อเข้าใช้งาน</button>
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
</body>
</html>