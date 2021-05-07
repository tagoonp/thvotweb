<?php
// require("../../../database_config/thvot/config.inc.php");
// require('../configuration/configuration.php');
// require('../configuration/database.php'); 

// $db = new Database();
// $conn = $db->conn();

// $stage = '';
// if((isset($_REQUEST['stage'])) && ($_REQUEST['stage'] != '') && ($_REQUEST['stage'] != null)){
//     $stage = mysqli_real_escape_string($conn, $_REQUEST['stage']);
// }

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

    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/fontawesome/css/all.min.css" >
    <link rel="stylesheet" href="../node_modules/sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" href="../node_modules/preload.js/dist/css/preload.css">
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo filemtime('../assets/css/style.css'); ?>" type="text/css">
</head>
<body class="bg-main">

    <div class="header  bg-light">
        <div class="container-fluid">
            <!-- <nav class="navbar navbar-expand-lg fixed-top navbar-light  bg-light justify-content-between">
                <a class="navbar-brand" href="#"><i class="fas fa-bars"></i></a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse  mr-auto" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active pt-1 mr-3">
                            <a href="./"><img src="https://thvot.com/img/thvot-web-logo.png" width="120" alt=""></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link th400" href="#">วิธีการใช้งาน</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">Disabled</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link th400" href="#">วิธีการใช้งาน</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">Disabled</a>
                        </li>
                    </ul>

                </div>

                <div class="collapse navbar-collapse" id="navbarNav2">
                    
                </div>
            </nav> -->

            <nav class="navbar navbar-expand-lg navbar-light bg-light pl-0 pl-sm-3 pr-0 pr-sm-3">
                <a class="navbar-brand d-none d-sm-block" href="#"><i class="fas fa-bars"></i></a>
                <a class="navbar-brand" href="#"><img src="https://thvot.com/img/thvot-web-logo.png" width="120" alt=""></a>
                <a class="navbar-brand d-block d-sm-none" href="#"><i class="fas fa-bars"></i></a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link th400" href="#">วิธีการใช้งาน</a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <ul class="navbar-nav mr-3">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle th400" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    สวัสดี, คุณ
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </li>
                        </ul>
                        <button class="btn btn-success my-2 my-sm-0 th200" type="button">ออกจากระบบ</button>
                    </form>

                    

                </div>
            </nav>
        </div>
    </div>

    <div class="main-content mt-5 pt-1">
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
                                    <input type="text" class="form-control" require id="txtUsername" name="txtUsername" autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="">รหัสผ่าน : <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" require id="txtPassword" name="txtPassword">
                                </div>
                                <div class="form-group pt-3">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 pb-3"><button class="btn btn-primary th200" type="submit">ลงชื่อเข้าใช้งาน</button></div>
                                        <div class="col-12 col-sm-6 pb-3">
                                            <a href="register.php" class="float-right text-muted d-none d-sm-block">สมัครใช้งานระบบ</a>
                                            <a href="register.php" class="text-muted d-block d-sm-none mt-3">สมัครใช้งานระบบ</a>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="../node_modules/preload.lv2.js/dist/js/preload.js"></script>

    <script>

        $(document).ready(function(){
            preload.hide()
            
        })

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