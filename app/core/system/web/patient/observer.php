<?php 
require('../../../../../../database_config/thvot/config.inc.php');
require('../../../../config/configuration.php');
require('../../../../config/database.php'); 
require('../../../../config/patient.role.php'); 

$db = new Database();
$conn = $db->conn();

$stage = '';
if(isset($_GET['stage'])){ 
    $stage = mysqli_real_escape_string($conn, $_GET['stage']);
}

require('../../../../config/user.inc.php'); 

$menu = 2;
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
    <title>THVOT : พี่เลี้ยง</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../../../tools/dropzone/dist/min/dropzone.min.css">
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

<body  style="background: #fff;" class="vertical-layout vertical-menu-modern 2-columns  navbar-sticky footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" >

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
                        <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
                            <div class="card" style="box-shadow: none;">
                                <div class="card-body pt-1 p-0">
                                    <h4 class="text-center">ติดต่อพยาบาลคลินิก / พี่เลี้ยง</h4>
                                    <div class="card mb-0">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="text-center">
                                                    <?php 
                                                    $strSQL = "SELECT * FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                                                               WHERE a.hcode = '".$user['hcode']."' AND b.info_use = '1' AND a.delete_status = '0' AND a.role = 'manager' LIMIT 1 ";
                                                    $resObsInfo = $db->fetch($strSQL, false);
                                                    if($resObsInfo){
                                                        ?>
                                                        <div>
                                                            <img src="<?php echo $resObsInfo['profile_img']; ?>" alt="" class="img-fluid mb-1" style="border-radius: 50%; width: 50%;">
                                                        </div>
                                                        <?php
                                                        echo "<h4 class='text-dark'>".$resObsInfo['fname']. " " . $resObsInfo['lname'] ."</h4>";
                                                       
                                                    }else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                </div>

                                                สถานบริการที่ตรวจติดตาม<br>(พยาบาลคลินิก)
                                                <div class="text-center">
                                                    <?php 
                                                    $strSQL = "SELECT hserv FROM vot2_projecthospital WHERE phoscode = '".$user['hcode']."'";
                                                    $resObs = $db->fetch($strSQL, false);
                                                    if($resObs){
                                                        echo "<h6 class='text-darj'>".$resObs['hserv']."</h6>";
                                                    }else{
                                                        echo "-";
                                                    }
                                                    ?>

                                                    <?php 
                                                    if($resObsInfo){
                                                        ?>
                                                        <div>
                                                            <a href="tel:<?php echo $resObsInfo['phone']; ?>" class="btn btn-danger round"><i class="bx bxs-phone-call"></i> <?php echo $resObsInfo['phone']; ?></a>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="text-center">
                                                    <?php 
                                                    $strSQL = "SELECT * FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                                                               WHERE b.info_uid = '".$user['obs_uid']."' AND b.info_use = '1' AND a.delete_status = '0'";
                                                    $resObsInfo = $db->fetch($strSQL, false);
                                                    if($resObsInfo){
                                                        ?>
                                                        <div>
                                                            <img src="<?php echo $resObsInfo['profile_img']; ?>" alt="" class="img-fluid mb-1" style="border-radius: 50%; width: 50%;">
                                                        </div>
                                                        <?php
                                                        echo "<h4 class='text-dark'>".$resObsInfo['fname']. " " . $resObsInfo['lname'] ."</h4>";
                                                       
                                                    }else{
                                                        echo "-";
                                                    }
                                                    ?>
                                                </div>

                                                รพ.สต. / รพ. ที่กำกับการกินยา<br>(พี่เลี้ยง)
                                                <div class="text-center">
                                                    <?php 
                                                    $strSQL = "SELECT hserv FROM vot2_projecthospital WHERE phoscode = '".$user['obs_hcode']."'";
                                                    $resObs = $db->fetch($strSQL, false);
                                                    if($resObs){
                                                        echo "<h6 class='text-darj'>".$resObs['hserv']."</h6>";
                                                    }else{
                                                        echo "-";
                                                    }
                                                    ?>

                                                    <?php 
                                                    if($resObsInfo){
                                                        ?>
                                                        <div>
                                                            <a href="tel:<?php echo $resObsInfo['phone']; ?>" class="btn btn-danger round"><i class="bx bxs-phone-call"></i> <?php echo $resObsInfo['phone']; ?></a>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    <script src="../../../tools/dropzone/dist/min/dropzone.min.js"></script>
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

    <!-- <script src="../../../app-assets/js/scripts/custom/dashboard-ecommerce.js"></script> -->
    <!-- END: Page JS-->

    <script>

    </script>

</body>
<!-- END: Body-->

</html>