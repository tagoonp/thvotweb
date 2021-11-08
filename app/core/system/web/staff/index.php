<?php 
require('../../../../../../database_config/thvot/config.inc.php');
require('../../../../config/configuration.php');
require('../../../../config/database.php'); 
require('../../../../config/staff.role.php'); 

if(isMobile()){
    header('Location: ./index_mobile');
}

$db = new Database();
$conn = $db->conn();

$stage = '';
if(isset($_GET['stage'])){ 
    $stage = mysqli_real_escape_string($conn, $_GET['stage']);
}

require('../../../../config/user.inc.php'); 

$menu = 0;
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
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/swiper.min.css">
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
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/dashboard-ecommerce.css">
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
                        <ul class="nav navbar-nav bookmark-icons">
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-calendar.html" data-toggle="tooltip" data-placement="top" title="Calendar"><i class="ficon bx bx-calendar-alt"></i></a></li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right">
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
                            <img src="https://thvot.com/img/thvot-logo.png" alt="" width="35" style="margin-top: -10px;">
                        </div>
                        <h2 class="brand-text mb-0">THVOT</h2>
                    </a></li>
                <li class="nav-item vertical-menu-modern"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i></a></li>
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
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                    <div class="row">
                        <!-- Greetings Content Starts -->
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card"  style="background: transparent !important; box-shadow: none;" onclick="window.location = 'app-patient-list'">
                                <div class="card-body pt-1 bg-primary round">
                                    <div class="row">
                                        <div class="col-8">
                                            <div><p class="mb-0 text-white">จำนวนผู้ป่วยที่ดูแล</p></div>
                                            <div><h2 class="greeting-text text-white">
                                                <?php 
                                                $strSQL = "SELECT a.uid
                                                            FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                                                            INNER JOIN vot2_chospital c ON a.hcode = c.hoscode 
                                                            WHERE 
                                                            a.obs_hcode = '".$_SESSION['thvot_hcode']."' 
                                                            AND b.info_use = '1' 
                                                            AND a.delete_status = '0' 
                                                            AND a.role = 'patient'
                                                            AND a.active_status = '1'
                                                            AND a.verify_status = '1'
                                                            AND a.cal_end_obsdate >= '$date'
                                                            AND a.patient_type IN ('TESTER', 'VOT')
                                                            AND a.obs_uid = '".$_SESSION['thvot_uid']."'
                                                        ";
                                                if($_SESSION['thvot_role'] == 'manager'){

                                                    $strSQL = "SELECT a.uid
                                                            FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                                                            INNER JOIN vot2_chospital c ON a.hcode = c.hoscode 
                                                            WHERE 
                                                            (a.hcode = '".$_SESSION['thvot_hcode']."' OR a.reg_hcode = '".$_SESSION['thvot_hcode']."')
                                                            AND b.info_use = '1' 
                                                            AND a.delete_status = '0' 
                                                            AND a.role = 'patient'
                                                            AND a.active_status = '1'
                                                            AND a.verify_status = '1'
                                                            AND a.cal_end_obsdate >= '$date'
                                                            AND a.patient_type IN ('TESTER', 'VOT')
                                                            AND a.obs_uid = '".$_SESSION['thvot_uid']."'
                                                        ";
                                                }
                                                $resCount = $db->fetch($strSQL, true, true);
                                                if(($resCount) && ($resCount['status'])){
                                                    echo sizeof($resCount['data']);
                                                }else{
                                                    echo "0";
                                                }
                                                
                                                ?>
                                                คน
                                            </h2></div>
                                            <div>
                                                <a href="#" class="badge badge-secondary round th">ดูรายชื่อผู้ป่วย</a>
                                            </div>
                                        </div>
                                        <div class="col-4 pl-0 pt-1">
                                            <img src="https://thvot.com/img/patient_banner.png" alt="" class="img-fluid">
                                        </div>
                                    </div>

                                    
                                    
                                </div>
                            </div>
                        </div>
                        <!-- Multi Radial Chart Starts -->
                        <div class="col-xl-4 col-md-6 col-12 dashboard-visit">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card" style="background: transparent !important; box-shadow: none;" onclick="window.location = 'app-video-patient'">
                                        <div class="card-body pt-1 bg-warning round">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div><p class="mb-0 text-white text-center">จำนวนวิดีโอที่ยังไม่ได้ดูวันนี้</p></div>
                                                    <div>
                                                        <h2 class="greeting-text text-white text-center mb-0">
                                                        <?php 
                                                        $strSQL = "SELECT COUNT(a.fu_id) cn FROM vot2_followup a
                                                                    WHERE 
                                                                    a.fu_view = '0' 
                                                                    AND a.fu_delete = '0'
                                                                    AND a.fu_date = '$date'
                                                                    AND a.fu_status = 'non-verify'
                                                                    AND a.fu_username IN 
                                                                    (SELECT username FROM vot2_account WHERE obs_hcode = '".$_SESSION['thvot_hcode']."' AND obs_uid = '".$_SESSION['thvot_uid']."' AND cal_end_obsdate >= '$date' AND delete_status = '0' AND patient_type IN ('TESTER', 'VOT')) 
                                                                  ";
                                                        if($_SESSION['thvot_hcode'] == 'manager'){
                                                            $strSQL = "SELECT COUNT(a.fu_id) cn FROM vot2_followup a
                                                                        WHERE 
                                                                        a.fu_view = '0' 
                                                                        AND a.fu_delete = '0'
                                                                        AND a.fu_date = '$date'
                                                                        AND a.fu_status = 'non-verify'
                                                                        AND a.fu_username IN 
                                                                        (SELECT username FROM vot2_account WHERE (hcode = '".$_SESSION['thvot_hcode']."' OR reg_hcode = '".$_SESSION['thvot_hcode']."') AND cal_end_obsdate >= '$date' AND delete_status = '0' AND patient_type IN ('TESTER', 'VOT')) 
                                                                    ";
                                                        }
                                                        $resCount = $db->fetch($strSQL, false);
                                                        if($resCount){
                                                            echo $resCount['cn'];
                                                        }else{
                                                            echo "0";
                                                        }
                                                        ?>
                                                        
                                                        </h2>
                                                        <div class="text-center text-white">
                                                        วิดีโอ
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 text-center">
                                                    <img src="https://thvot.com/img/video_banner.png" alt="" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card" style="background: transparent !important; box-shadow: none;">
                                        <div class="card-body pt-1 bg-danger round">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div><p class="mb-0 text-white text-center">วิดีโอที่ดูไม่ทันใน 24 ชม.</p></div>
                                                    <div>
                                                        <h2 class="greeting-text text-white text-center mb-0">
                                                        <?php 
                                                        $strSQL = "SELECT COUNT(a.fu_id) cn FROM vot2_followup a
                                                                    WHERE 
                                                                    a.fu_view = '0' 
                                                                    AND a.fu_delete = '0'
                                                                    AND a.fu_username IN 
                                                                    (SELECT username FROM vot2_account WHERE obs_hcode = '".$_SESSION['thvot_hcode']."' AND obs_uid = '".$_SESSION['thvot_uid']."'  AND patient_type IN ('TESTER', 'VOT')) 
                                                                  ";
                                                        if($_SESSION['thvot_role'] == 'manager'){
                                                            $strSQL = "SELECT COUNT(a.fu_id) cn FROM vot2_followup a
                                                                            WHERE 
                                                                            a.fu_view = '0' 
                                                                            AND a.fu_delete = '0'
                                                                            AND a.fu_username IN 
                                                                            (SELECT username FROM vot2_account WHERE (hcode = '".$_SESSION['thvot_hcode']."' OR reg_hcode = '".$_SESSION['thvot_hcode']."')  AND patient_type IN ('TESTER', 'VOT')) 
                                                                        ";
                                                        }
                                                        $resCount = $db->fetch($strSQL, false);
                                                        if($resCount){
                                                            echo $resCount['cn'];
                                                        }else{
                                                            echo "0";
                                                        }
                                                        ?>
                                                        
                                                        </h2>
                                                        <div class="text-center text-white">
                                                        วิดีโอ
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 text-center">
                                                    <img src="https://thvot.com/img/calendar_banner.png" alt="" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="card"  style="background: transparent !important; box-shadow: none;" onclick="window.location = 'app-patient-list'">
                                <div class="card-body pt-1 bg-secondary round">
                                    <div class="row">
                                        <div class="col-8">
                                            <div><p class="mb-0 text-white">จำนวนผู้ป่วยที่ยังไม่กินยา/กินไม่ครบ</p></div>
                                            <div><h2 class="greeting-text text-white">
                                                <?php 

                                                $strSQL = "SELECT COUNT(a.fud_id) cn FROM vot2_followup_dummy a
                                                            WHERE 
                                                            a.fud_date = '$date' 
                                                            AND a.fud_status != 'complete'
                                                            AND a.fud_username IN 
                                                            (
                                                                SELECT username 
                                                                FROM vot2_account 
                                                                WHERE 
                                                                obs_hcode = '".$_SESSION['thvot_hcode']."'
                                                                AND cal_end_obsdate >= '$date'
                                                                AND delete_status = '0'
                                                                AND stop_drug = '0'
                                                                AND role = 'patient'
                                                                AND patient_type IN ('TESTER', 'VOT')
                                                            ) 
                                                        ";
                                                if($_SESSION['thvot_role'] == 'manager'){
                                                    $strSQL = "SELECT COUNT(a.fud_id) cn FROM vot2_followup_dummy a
                                                                WHERE 
                                                                a.fud_date = '$date' 
                                                                AND a.fud_status != 'complete'
                                                                AND a.fud_username IN 
                                                                (
                                                                    SELECT username 
                                                                    FROM vot2_account 
                                                                    WHERE 
                                                                    (hcode = '".$_SESSION['thvot_hcode']."' OR reg_hcode = '".$_SESSION['thvot_hcode']."')
                                                                    AND cal_end_obsdate >= '$date'
                                                                    AND delete_status = '0'
                                                                    AND stop_drug = '0'
                                                                    AND role = 'patient'
                                                                    AND patient_type IN ('TESTER', 'VOT')
                                                                ) 
                                                            ";
                                                }
                                                $resCount = $db->fetch($strSQL, false);
                                                if($resCount){
                                                    echo $resCount['cn'];
                                                }else{
                                                    echo "0";
                                                }
                                                ?>
                                                คน
                                            </h2></div>
                                            <div>
                                                <a href="#" class="badge badge-danger round th">ดูรายชื่อผู้ป่วย</a>
                                            </div>
                                        </div>
                                        <div class="col-4 pl-0 pt-1">
                                            <img src="https://thvot.com/img/patient_banner.png" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6"></div>

                        
                    </div>
                    
                </section>
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <?php 
    require("./control/footer.php");
    ?>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../../app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/swiper.min.js"></script>
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

    <script src="../../../app-assets/js/scripts/custom/dashboard-ecommerce.js"></script>
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>