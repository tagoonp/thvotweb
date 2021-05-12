<?php
require("../../../database_config/thvot/config.inc.php");
require('../configuration/configuration.php');
require('../configuration/database.php'); 
require('../configuration/user.inc.php'); 

$stage = '';
if((isset($_REQUEST['stage'])) && ($_REQUEST['stage'] != '') && ($_REQUEST['stage'] != null)){
    $stage = mysqli_real_escape_string($conn, $_REQUEST['stage']);
}

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

            <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light pl-3 pl-sm-3 pr-0 pr-sm-3">
                <a class="navbar-brand d-none d-sm-block" href="#"><i class="fas fa-bars"></i></a>
                <a class="navbar-brand" href="./"><img src="https://thvot.com/img/thvot-web-logo.png" width="120" alt=""></a>
                <a class="navbar-brand d-block d-sm-none" href="#"><i class="fas fa-bars"></i></a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link th400" href="https://thvot.com/documents/">วิธีการใช้งาน</a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <ul class="navbar-nav mr-3">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle th400" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    สวัสดี, คุณ<?php echo $user['fname']." ".$user['lname']; ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item th200" href="account-info.php"><i class="fas fa-user"></i> โปรไฟล์</a>
                                <a class="dropdown-item th200" href="account-security.php"><i class="fas fa-key"></i> ความปลอดภัย</a>
                                <a class="dropdown-item th200" href="Javascript:user.logout()"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a>
                                </div>
                            </li>
                        </ul>
                        <!-- <button class="btn btn-success my-2 my-sm-0 th200" type="button">ออกจากระบบ</button> -->
                    </form>

                    

                </div>
            </nav>
        </div>
    </div>

    <div class="main-content mt-5 pl-0 pr-0 pt-5">
        <div class="menu-div" style="width: 280px; position: fixed; left: 0px; top: 100px;">
            <div class="menu-item" style="cursor: pointer;" onclick="window.location = './'">
                <div class="row">
                    <div class="col-1"><i class="fas fa-home"></i></div>
                    <div class="col">หน้าแรก</div>
                </div>
            </div>
            <div class="menu-item menu-item-active" style="cursor: pointer;" onclick="window.location = 'account-info.php'">
                <div class="row">
                    <div class="col-1"><i class="far fa-user"></i></div>
                    <div class="col">ข้อมูลส่วนตัว</div>
                </div>
            </div>

            <div class="menu-item" style="cursor: pointer;" onclick="window.location = 'account-activity.php'">
                <div class="row">
                    <div class="col-1"><i class="far fa-list-alt"></i></div>
                    <div class="col">บันทึกการใช้งาน</div>
                </div>
            </div>

            <div class="menu-item" style="cursor: pointer;" onclick="window.location = 'account-security.php'">
                <div class="row">
                    <div class="col-1"><i class="fas fa-unlock-alt"></i></div>
                    <div class="col">ความปลอดภัย</div>
                </div>
            </div>

            <hr>

            <div class="menu-item" style="cursor: pointer;" onclick="user.logout()">
                <div class="row">
                    <div class="col-1"><i class="fas fa-sign-out-alt"></i></div>
                    <div class="col">ออกจากระบบ</div>
                </div>
            </div>

        </div>


        <div class="container-fluid">
            
            <div class="row">
                <div class="col-12 col-sm-6 offset-sm-3">

                    <div class="text-center pb-3">
                        <h2>ข้อมูลส่วนตัว</h2>
                        <h5 class="text-muted th200">User profile</h5>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h5>ข้อมูลทั่วไป</h5>
                            <table class="table mt-3 mb-0" style="font-size: 0.8em;">
                                <tbody>
                                    <tr>
                                        <td style="width: 150px;" class="text-muted pl-0">ชื่อ - นามสกุล</td>
                                        <td><?php echo $user['fname']." ".$user['lname']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted pl-0">หน่วยงานที่สังกัด</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted pl-0">รหัสผ่าน</td>
                                        <td>
                                            <?php 
                                            $i = 0;
                                            $len = 10;
                                            if($user['password_len'] != null){
                                                $len = $user['password_len'];
                                            }
                                            for ($i=0; $i < $len; $i++) { 
                                                echo '<i class="fas fa-circle mr-1 text-muted" style="font-size: 0.1em !important;"></i>';
                                            }
                                            ?>
                                            <div style="font-size: 0.9em;" class="text-muted pt-2">
                                                แก้ไขล่าสุดเมื่อ : <?php echo $user['p_udatetime']; ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5>ข้อมูลการติดต่อ</h5>
                            <table class="table mt-3 mb-0" style="font-size: 0.8em;">
                                <tbody>
                                    <tr>
                                        <td class="text-muted pl-0" style="width: 150px;">อีเมลแอดเดรส</td>
                                        <td><?php echo $user['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted pl-0">หมายเลขโทรศัพท์</td>
                                        <td><?php echo $user['phone']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
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

    <script type="text/javascript" src="../assets/js/user.js?v=<?php echo filemtime('../assets/js/user.js'); ?>"></script>

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