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

            <nav class="navbar  fixed-top navbar-expand-lg navbar-light bg-light pl-3 pl-sm-3 pr-0 pr-sm-3">
                <a class="navbar-brand d-none d-sm-block" href="#"><i class="fas fa-bars"></i></a>
                <a class="navbar-brand" href="./"><img src="https://thvot.com/img/thvot-web-logo.png" width="120" alt=""></a>
                <a class="navbar-brand d-block d-sm-none" href="#"><i class="fas fa-bars"></i></a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link th400" href="https://thvot.com/documents/">วิธีการใช้งาน</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle th400" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                โครงการติดตาม
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php 
                                $strSQL = "SELECT * FROM vot2_project WHERE proj_uid = '$uid' AND proj_delete = '0'";
                                $result = $db->fetch($strSQL, true, false);
                                if($result['status']){
                                    foreach($result['data'] as $row){
                                        ?>
                                        <a class="dropdown-item th200" href="#" onclick="project.setSession('<?php echo $row['proj_id']; ?>', 'project-dashboard.php')"><?php echo $row['proj_title']; ?></a>
                                        <?php
                                    }
                                    ?>
                                    <hr class="mb-1 mt-1">
                                    <?php
                                }
                                ?>
                                <a class="dropdown-item th200" href="#" data-toggle="modal" data-target="#modalCreateProject"><i class="fas fa-folder-plus"></i> สร้างโครงการใหม่</a>
                            </div>
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

    <!-- Modal -->
    <div class="modal fade" id="modalCreateProject" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">สร้างโครงการใหม่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../controller/project.php?stage=1" method="post" id="projectForm">
                    <div class="form-group">
                        <label for="">ชื่อโครงการ / ชื่องาน : <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="txtProjectTitle" name="txtProjectTitle">
                    </div>

                    <div class="form-group">
                        <label for="">รายละเอียดอย่างสั้น : </label>
                        <textarea name="txtProjectDesc" id="txtProjectDesc" cols="10" rows="10" class="form-control" style="height: 200px;"></textarea>
                    </div>

                    <button class="btn btn-primary" type="submit" style="display: none;">Create</button>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary th200" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary th200" onclick="checkProject()">สร้าง</button>
            </div>
            </div>
        </div>
    </div>

    <div class="main-content mt-5 pl-0 pr-0 pt-5">
        <div class="row">
            <div class="col-12 col-sm-4 col-md-3 d-none d-sm-block">
                <div class="menu-div" style="width: 280px; position: fixed; left: 0px; top: 100px;">
                    <div class="menu-item" style="cursor: pointer;" onclick="window.location='./'">
                        <div class="row">
                            <div class="col-1"><i class="fas fa-home"></i></div>
                            <div class="col">หน้าแรก</div>
                        </div>
                    </div>

                    <div class="menu-item menu-item-active" style="cursor: pointer;" onclick="window.location='project-list.php'">
                        <div class="row">
                            <div class="col-1"><i class="fas fa-folder"></i></div>
                            <div class="col">โครงการติดตาม</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-8 col-md-9">
                <div class="row">
                    <div class="col-12 pr-sm-5 pl-4">
                        <h3>โครงการ</h3>

                        <div class="card mb-5 mt-3"  style="border: none;">
                            <div class="card-body p-0">
                                <div class="table-responsive" style="min-height: 300px; max-height: 600px; overflow: hidden;">
                                    <table class="table mb-0 table-borderless" style="font-size: 0.8em;">
                                        <thead>
                                            <tr>
                                                <th class="text-dark pb-0">
                                                    <div class="card" style="border: none;">
                                                        <div class="card-body pt-0 pb-0">
                                                            <div class="row">
                                                                <div class="col-2 col-sm-1">ID</div>
                                                                <div class="col col-sm-6">
                                                                    โครงการ
                                                                </div>
                                                                <div class="col col-sm-2 d-none d-sm-block">
                                                                    สถานะ
                                                                </div>
                                                                <div class="col col-sm-3"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $strSQL = "SELECT * FROM vot2_project 
                                                    WHERE proj_uid = '$uid' 
                                                    AND proj_delete = '0'
                                                    ORDER BY proj_udatetume DESC
                                                    ";
                                            $result = $db->fetch($strSQL, true, false);
                                            if($result['status']){
                                                foreach($result['data'] as $row){
                                                    ?>
                                                    <tr>
                                                        <td colspan="4" class="pb-0">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-1 col-sm-1 pt-sm-1"><?php echo $row['proj_id']; ?></div>
                                                                                <div class="col-10 col-sm-6 pt-sm-1">
                                                                                    <?php echo $row['proj_title']; ?>
                                                                                    <div style="font-size: 0.8em;">
                                                                                    <?php echo $row['proj_desc']; ?>
                                                                                    </div> 

                                                                                    <div class="form-check d-block d-sm-none">
                                                                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                                                        <label class="form-check-label text-danger" for="defaultCheck1">
                                                                                            ปิดการใช้งาน
                                                                                        </label>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="col-sm-2 d-none d-sm-block pt-sm-1">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                                                        <label class="form-check-label text-danger" for="defaultCheck1">
                                                                                            ปิดการใช้งาน
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-11 offset-1 pt-2 pt-sm-0 col-sm-2 text-sm-right">
                                                                                    <button class="btn btn-sm" onclick="project.setSession('<?php echo $row['proj_id']; ?>', 'project-dashboard.php')"><i class="fas fa-search" style="font-size: 0.8em;"></i></button>
                                                                                    <button class="btn btn-sm" onclick="project.delete('<?php echo $row['proj_id']; ?>')"><i class="fas fa-trash" style="font-size: 0.8em;" ></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                                    <?php
                                                }
                                            }else{
                                                ?>
                                                <tr>
                                                    <td colspan="3" class="text-center">ไม่พบบันทึกกิจกรรม</td>
                                                </tr>  
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                
                            </div>
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
    <script type="text/javascript" src="../assets/js/project.js?v=<?php echo filemtime('../assets/js/project.js'); ?>"></script>

    <script>

        $(document).ready(function(){
            preload.hide()
            
        })

        $(function(){

        })

        function checkProject(){
            $check = 0
            $('.form-control').removeClass('is-invalid')
            if($('#txtProjectTitle').val() == ''){
                $('#txtProjectTitle').addClass('is-invalid')
                $check++;
            }
            if($check != 0){
                return false;
            }
            $('#projectForm').submit()
        }
    </script>
</body>
</html>