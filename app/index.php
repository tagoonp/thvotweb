<?php 
require('../../database_config/thvot/config.inc.php');
require('./config/configuration.php');
require('./config/database.php'); 

$db = new Database();
$conn = $db->conn();

$stage = '';
if(isset($_GET['stage'])){ 
    $stage = mysqli_real_escape_string($conn, $_GET['stage']);
}
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Frest admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Frest admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>THVOT : ระบบการติดตามการรับประทานยา</title>
    <link rel="apple-touch-icon" href="./app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="./app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="./app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="./app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/themes/semi-dark-layout.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="./app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="./app-assets/css/pages/authentication.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css?v=<?php echo filemtime('./assets/css/style.css'); ?>">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- login page start -->
                <section id="auth-login" class="row flexbox-container">
                    <div class="col-xl-8 col-11">
                        <div class="card bg-authentication mb-0">
                            <div class="row m-0">
                                <!-- left section-login -->
                                <div class="col-md-6 col-12 px-0">
                                    <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h2 class="text-left mb-1">THVOT</h2>
                                                <h3>ระบบการติดตามการรับประทานยา</h3>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            
                                            <form action="./controller/auth?stage=login" method="post" autocomplete="off" onsubmit="return auth.chk_login();">
                                                <div class="form-group mb-50">
                                                    <label class="text-bold-600" for="exampleInputEmail1">Email address / ชื่อบัญชีผู้ใช้งาน : </label>
                                                    <input type="text" class="form-control" id="txtUsername" name="txtUsername" placeholder="Email address / Username" autofocus></div>
                                                <div class="form-group">
                                                    <label class="text-bold-600" for="exampleInputPassword1">รหัสผ่าน :</label>
                                                    <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Password">
                                                </div>
                                                <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                                    <!-- <div class="text-left">
                                                    <small class="mr-25">ยังไม่มีบัฯชีผู้ใช้งาน</small><a href="auth-register"><small>ลงทะเบียนที่นี่</small></a>
                                                    </div> -->
                                                    <div class="text-right"><a href="auth-forget-password" class="card-link"><small>ลืมรหัสผ่าน?</small></a></div>
                                                </div>
                                                <button type="submit" class="btn btn-primary glow w-100 position-relative">เข้าสู่ระบบ<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                            </form>

                                            <!-- <div class="divider">
                                                <div class="divider-text text-uppercase text-muted"><small>หรือเข้าสู่ระบบด้วย Social media account</small>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-md-row flex-column justify-content-around">
                                                <a href="javascript:void(0);" class="btn btn-social btn-block btn-success mt-0 btn-facebook font-small-3">
                                                    <i class="bx bxl-facebook-square font-medium-3"></i><span class="pl-50 d-block text-center">Line</span></a>
                                            </div> -->
                                            
                                            <div class="text-center"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- right section image -->
                                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                                    <img class="img-fluid" src="./app-assets/images/pages/login.png" alt="branding logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- login page ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->

    <script src="./app-assets/vendors/js/vendors.min.js"></script>
    <script src="./app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
    <script src="./app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
    <script src="./app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>

    
    <!-- <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script> -->
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="./app-assets/js/scripts/configs/vertical-menu-light.js"></script>
    <script src="./app-assets/js/core/app-menu.js"></script>
    <script src="./app-assets/js/core/app.js"></script>
    <script src="./app-assets/js/scripts/components.js"></script>
    <script src="./app-assets/js/scripts/footer.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="./assets/js/scripts/authen.js?v=<?php echo filemtime('./assets/js/scripts/authen.js'); ?>"></script>
    <!-- END: Page JS-->
</body>
<!-- END: Body-->

</html>