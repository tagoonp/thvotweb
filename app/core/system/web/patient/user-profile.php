<?php 
require('../../../../config/config.inc.php');
require('../../../../config/configuration.php');
require('../../../../config/database.php'); 
require('../../../../config/patient.role.php'); 

$db = new Database();
$conn = $db->conn();

$stage = '';
if(isset($_GET['stage'])){ 
    $stage = mysqli_real_escape_string($conn, $_GET['stage']);
}

require('../../../../config/user_patient.inc.php'); 

$menu = 99;
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
    <title>THVOT : ตั้งเวลาแจ้งเตือน</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="../../../tools/preload.js/dist/css/preload.css">
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
                                <div class="card-body pt-1 pl-1 pr-1">
                                    <h6 class="text-center mb-2">ข้อมูลผู้ป่วย</h6>
                                    <div class="text-center">
                                    <img class="round" src="<?php if(($user['profile_img'] != '') && ($user['profile_img'] != null)){ echo $user['profile_img']; }else{ echo "../../../app-assets/images/portrait/small/avatar-s-11.jpg"; }?>" alt="avatar" height="140" width="140" style="border-radius: 50%; margin-bottom: 20px;">
                                    </div>
                                    <h4 class="text-center mb-2"><?php echo $user['fname']." ".$user['lname']; ?></h4>
                                    <h6 class="text-center mb-5">ID : <?php echo $user['username']; ?></h6>
                                    <?php 
                                    if($user['profile_status'] == '1'){
                                        ?>
                                        <button class="btn btn-block btn-outline-secondary round mt-2" onclick="takePhoto()"><i class="bx bx-camera mr-50"></i> เปลี่ยนรูปโปรไฟล์</button>    
                                        <?php
                                    }
                                    ?>
                                    <button class="btn btn-block btn-danger round mt-1" onclick="signout()"><i class="bx bx-power-off mr-50"></i> ออกจากระบบ</button>
                                    <div class="pt-2 text-center" style="display: none;">
                                        <form action="#"  id="mydropzone" class="dropzone bg-danger text-white text-center" action="#" style="height: 150px; border-radius: 50%; width: 150px; border-width: 0px;">
                                            <div class="fallback">
                                                <input name="file" type="file" multiple />
                                            </div>
                                        </form>
                                        <!-- <i class="bx bx-video" style="font-size: 4.5em; margin-top: 40px; position: relative; margin-top: -100px;"></i> -->
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

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAoLb4C5rLn6joROEdlA9mXhBMS7Bxy9ig" async ></script>

    <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../../app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="../../../tools/preload.js/dist/js/preload.js"></script>
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

        var dropzone = new Dropzone("#mydropzone", {
            dictDefaultMessage: '<i class="bx bx-video" style="font-size: 4.8em; margin-top: -10px; padding-left: 10px;"></i>',
            url: '../../../../api/profile_upload.php?uid=' + window.localStorage.getItem('thvot_patient_web_uid'),
            acceptedFiles: 'image/*',
            maxFilesize: 100,
            init: function(){
                this.on("complete", function(file) {
                console.log(file);
                this.removeFile(file);
                console.log(file.xhr.responseText);
                if(file.xhr.responseText == "Y"){
                    window.location.reload()
                }else{
                    preload.hide()
                    Swal.fire({
                                        icon: "error",
                                        title: 'เกิดข้อผิดพลาด',
                                        text: 'อัพโหลดไม่สำเร็จ กรุณาลองใหม่อีกครั้ง',
                                        confirmButtonClass: 'btn btn-danger',
                                })
                }
                });
            },
            addedfile: function(){
                preload.show()
            }
        });

        $(document).ready(function(){
            preload.hide()
        })

        function takePhoto(){
            $('#mydropzone').trigger('click')
        }

        function saveAlertTime(){
            var param = { uid : '<?php echo $user['uid'];?>', hh: $('#txtHH').val() , mm: $('#txtMM').val() }
            var jxr = $.post("https://thvot.com/thvotweb/app/api/core-api?stage=set_notitime2", param, function(){}, 'json')
                        .always(function(snap){
                            console.log(snap);
                            if(snap.status == 'Success'){
                                window.location.reload()
                            }else{
                                preload.hide()
                                Swal.fire({
                                        icon: "error",
                                        title: 'เกิดข้อผิดพลาด',
                                        text: 'ไม่สามารถตั้งเวลาได้ กรุณาลองใหม่อีกครั้ง',
                                        confirmButtonClass: 'btn btn-danger',
                                })
                            }
                        })
        }

        
    </script>

</body>
<!-- END: Body-->

</html>