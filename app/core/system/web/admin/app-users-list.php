<?php 
require('../../../../../../database_config/thvot/config.inc.php');
require('../../../../config/configuration.php');
require('../../../../config/database.php'); 
require('../../../../config/admin.role.php'); 

$db = new Database();
$conn = $db->conn();

$stage = '';
if(isset($_GET['stage'])){ 
    $stage = mysqli_real_escape_string($conn, $_GET['stage']);
}

require('../../../../config/user.inc.php'); 


$menu = 1;
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="THVOT ระบบการติดตามยาผู้ป่วยวัณโรค">
    <meta name="author" content="Wisnior, Co, Ltd.">
    <title>THVOT : Administator</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/forms/select/select2.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/app-users.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css?v=<?php echo filemtime('../../../assets/css/style.css'); ?>">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-sticky footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Header-->
    <div class="header-navbar-shadow"></div>
    <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="javascript:void(0);"><i class="ficon bx bx-menu"></i></a></li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right">
     
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen"></i></a></li>
                        <?php 
                        require("./control/notification.php");
                        require("./control/profile_menu.php");
                        ?>
                        
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="./">
                        <div class="brand-logo">
                            <svg class="logo" width="26px" height="26px" viewbox="0 0 26 26" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>icon</title>
                                <defs>
                                    <lineargradient id="linearGradient-1" x1="50%" y1="0%" x2="50%" y2="100%">
                                        <stop stop-color="#5A8DEE" offset="0%"></stop>
                                        <stop stop-color="#699AF9" offset="100%"></stop>
                                    </lineargradient>
                                    <lineargradient id="linearGradient-2" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop stop-color="#FDAC41" offset="0%"></stop>
                                        <stop stop-color="#E38100" offset="100%"></stop>
                                    </lineargradient>
                                </defs>
                                <g id="Sprite" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="sprite" transform="translate(-69.000000, -61.000000)">
                                        <g id="Group" transform="translate(17.000000, 15.000000)">
                                            <g id="icon" transform="translate(52.000000, 46.000000)">
                                                <path id="Combined-Shape" d="M13.5909091,1.77272727 C20.4442608,1.77272727 26,7.19618701 26,13.8863636 C26,20.5765403 20.4442608,26 13.5909091,26 C6.73755742,26 1.18181818,20.5765403 1.18181818,13.8863636 C1.18181818,13.540626 1.19665566,13.1982714 1.22574292,12.8598734 L6.30410592,12.859962 C6.25499466,13.1951893 6.22958398,13.5378796 6.22958398,13.8863636 C6.22958398,17.8551125 9.52536149,21.0724191 13.5909091,21.0724191 C17.6564567,21.0724191 20.9522342,17.8551125 20.9522342,13.8863636 C20.9522342,9.91761479 17.6564567,6.70030817 13.5909091,6.70030817 C13.2336969,6.70030817 12.8824272,6.72514561 12.5388136,6.77314791 L12.5392575,1.81561642 C12.8859498,1.78721495 13.2366963,1.77272727 13.5909091,1.77272727 Z"></path>
                                                <path id="Combined-Shape" d="M13.8863636,4.72727273 C18.9447899,4.72727273 23.0454545,8.82793741 23.0454545,13.8863636 C23.0454545,18.9447899 18.9447899,23.0454545 13.8863636,23.0454545 C8.82793741,23.0454545 4.72727273,18.9447899 4.72727273,13.8863636 C4.72727273,13.5378966 4.74673291,13.1939746 4.7846258,12.8556254 L8.55057141,12.8560055 C8.48653249,13.1896162 8.45300462,13.5340745 8.45300462,13.8863636 C8.45300462,16.887125 10.8856023,19.3197227 13.8863636,19.3197227 C16.887125,19.3197227 19.3197227,16.887125 19.3197227,13.8863636 C19.3197227,10.8856023 16.887125,8.45300462 13.8863636,8.45300462 C13.529522,8.45300462 13.180715,8.48740462 12.8430777,8.55306931 L12.8426531,4.78608796 C13.1851829,4.7472336 13.5334422,4.72727273 13.8863636,4.72727273 Z" fill="#4880EA"></path>
                                                <path id="Combined-Shape" d="M13.5909091,1.77272727 C20.4442608,1.77272727 26,7.19618701 26,13.8863636 C26,20.5765403 20.4442608,26 13.5909091,26 C6.73755742,26 1.18181818,20.5765403 1.18181818,13.8863636 C1.18181818,13.540626 1.19665566,13.1982714 1.22574292,12.8598734 L6.30410592,12.859962 C6.25499466,13.1951893 6.22958398,13.5378796 6.22958398,13.8863636 C6.22958398,17.8551125 9.52536149,21.0724191 13.5909091,21.0724191 C17.6564567,21.0724191 20.9522342,17.8551125 20.9522342,13.8863636 C20.9522342,9.91761479 17.6564567,6.70030817 13.5909091,6.70030817 C13.2336969,6.70030817 12.8824272,6.72514561 12.5388136,6.77314791 L12.5392575,1.81561642 C12.8859498,1.78721495 13.2366963,1.77272727 13.5909091,1.77272727 Z" fill="url(#linearGradient-1)"></path>
                                                <rect id="Rectangle" x="0" y="0" width="7.68181818" height="7.68181818"></rect>
                                                <rect id="Rectangle" fill="url(#linearGradient-2)" x="0" y="0" width="7.68181818" height="7.68181818"></rect>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <h2 class="brand-text mb-0">THVOT</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <?php require("./control/admin-menu.php"); ?>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        
        <div class="content-wrapper">
            <div class="content-header row">

            </div>
            <div class="content-body">
                <h2 class="mb-2">รายชื่อผู้ใช้งานระบบ</h2>
                <!-- users list start -->
                <div class="row">
                    <div class="col-12 pb-1">
                        <button class="btn btn-primary" onclick="window.location = 'app-users-add'"><i class="bx bxs-user-plus"></i> เพิ่มบัญชีผู้ใช้ใหม่</button>
                    </div>
                </div>
                <section class="users-list-wrapper">
                    <div class="users-list-table">
                        <div class="card">
                            <div class="card-body">
                                <!-- datatable start -->
                                <div class="table-responsive">
                                    <table id="users-list-datatable" class="table">
                                        <thead>
                                            <tr>
                                                <th>ผู้ใช้งาน</th>
                                                <th>จำนวนผู้ป่วยที่ดูแล</th>
                                                <!-- <th>เวลาของกิจกรรมล่าสุด</th> -->
                                                <th>ยืนยันการใช้งาน</th>
                                                <th>สิทธิ์</th>
                                                <th>เปิด/ปิดการใช้งาน</th>
                                                <th style="width: 80px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $strSQL = "SELECT a.*, a.ID user_id, b.*, c.* FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                                                       LEFT JOIN vot2_projecthospital c ON a.hcode = c.phoscode
                                                      WHERE 
                                                      a.delete_status = '0' 
                                                      AND b.info_use = '1'
                                                      AND a.role != 'patient'
                                                      ";
                                            $result_list = $db->fetch($strSQL, true, false);
                                            if($result_list['status']){
                                                $c = 1;
                                                foreach($result_list['data'] as $row){
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <span style="font-size: 0.8em;">Username : <?php echo $row['username']; ?></span>
                                                            <div class="text-dark"><?php echo $row['fname']." ".$row['lname']; ?></div>
                                                            <div class="">สถานบริการ : <span class="badge badge-light-primary round"><?php echo $row['hcode']; ?></span> <br><?php echo $row['hserv']; ?></div>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            if($row['role'] == 'admin'){ 
                                                               ?>
                                                               <a href="./app-patient-list">ทั้งหมด</a>
                                                               <?php
                                                            }else if($row['role'] == 'moderator'){
                                                                $strSQL = "SELECT * FROM vot2_account WHERE role = 'patient' AND delete_status = '0'";
                                                                $resCount = $db->fetch($strSQL, true, true);
                                                                if(($resCount) && ($resCount['status'])){
                                                                    ?>
                                                                    <a href="app-patient-response?uid=<?php echo $row['uid'];?>"><?php echo $resCount['count']; ?></a>
                                                                    <?php
                                                                }else{
                                                                    echo "0";
                                                                }
                                                            }else if($row['role'] == 'manager'){
                                                                $strSQL = "SELECT * FROM vot2_account WHERE role = 'patient' 
                                                                           AND (hcode = '".$row['hcode']."' OR reg_hcode = '".$row['hcode']."')  AND delete_status = '0'";
                                                                $resCount = $db->fetch($strSQL, true, true);
                                                                if(($resCount) && ($resCount['status'])){
                                                                    ?>
                                                                    <a href="app-patient-response?uid=<?php echo $row['uid'];?>"><?php echo $resCount['count']; ?></a>
                                                                    <?php
                                                                }else{
                                                                    echo "0";
                                                                }
                                                            }else if($row['role'] == 'staff'){
                                                                $strSQL = "SELECT * FROM vot2_account WHERE role = 'patient' AND obs_hcode = '".$row['hcode']."' AND delete_status = '0'";
                                                                $resCount = $db->fetch($strSQL, true, true);
                                                                if(($resCount) && ($resCount['status'])){
                                                                    ?>
                                                                    <a href="app-patient-response?uid=<?php echo $row['uid'];?>"><?php echo $resCount['count']; ?></a>
                                                                    <?php
                                                                }else{
                                                                    echo "0";
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <!-- <td>30/04/2019</td> -->
                                                        <td class="pt-2">
                                                            <div class="custom-control mt-1 custom-switch custom-switch-success mr-2 mb-1">
                                                                <input type="checkbox"  onclick="admin_user.toggle_active('<?php echo $row['user_id'];?>')" class="custom-control-input" id="sw_active_<?php echo $row['user_id'];?>" <?php if($row['verify_status'] == 1){ echo "checked"; } ?>>
                                                                <label class="custom-control-label" for="sw_active_<?php echo $row['user_id'];?>"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            if($row['role'] == 'admin'){ echo "ผู้ดูแลระบบ"; }
                                                            if($row['role'] == 'moderator'){ echo "ผู้รับผิดชอบส่วนกลาง"; }
                                                            if($row['role'] == 'manager'){ echo "พยาบาลคลินิก"; }
                                                            if($row['role'] == 'staff'){ echo "พี่เลี้ยง"; }
                                                            if($row['role'] == 'patient'){ echo "ผู้ป่วย"; }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control mt-1 custom-switch custom-switch-success mr-2 mb-1">
                                                                <input type="checkbox" onclick="admin_user.toggle_status('<?php echo $row['user_id'];?>')" class="custom-control-input"  id="sw_status_<?php echo $row['user_id'];?>" <?php if($row['active_status'] == '1'){ echo "checked"; } ?>>
                                                                <label class="custom-control-label" for="sw_status_<?php echo $row['user_id'];?>"></label>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            <a href="app-users-edit?id=<?php echo $row['uid'];?>" class="mr-1"><i class="bx bx-edit-alt"></i></a>
                                                            <?php 
                                                            if($row['role'] != 'admin'){
                                                                ?>
                                                                <a href="Javascript:admin_user.delete_user('<?php echo $row['uid'];?>')" clsas=""><i class="bx bx-trash-alt text-danger"></i></a>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <a href="#" clsas="" disabled><i class="bx bx-trash-alt text-muted"></i></a>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $c++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- datatable ends -->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users list ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <?php 
    require("./control/footer.php");
    ?>


    <!-- BEGIN: Vendor JS-->
    <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../../app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/responsive.bootstrap4.min.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/polyfill.min.js"></script>
    <script src="../../../app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/scripts/configs/vertical-menu-light.js"></script>
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <script src="../../../app-assets/js/scripts/components.js"></script>
    <script src="../../../app-assets/js/scripts/footer.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="../../../assets/js/scripts/core.js?v=<?php echo filemtime('../../../assets/js/scripts/core.js'); ?>"></script>
    <script src="../../../assets/js/scripts/authen.js?v=<?php echo filemtime('../../../assets/js/scripts/authen.js'); ?>"></script>
    <script src="../../../app-assets/js/scripts/pages/app-users.js?v=<?php echo filemtime('../../../app-assets/js/scripts/pages/app-users.js'); ?>"></script>
    <script src="../../../assets/js/scripts/admin-user.js?v=<?php echo filemtime('../../../assets/js/scripts/admin-user.js'); ?>"></script>
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>