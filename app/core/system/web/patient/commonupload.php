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

require('../../../../config/user_patient.inc.php'); 

$menu = 0;
?>

<input type="hidden" id="txtUid" value="<?php echo $_SESSION['thvot_uid']; ?>">
<input type="hidden" id="txtRole" value="<?php echo $_SESSION['thvot_role']; ?>">
<input type="hidden" id="txtHcode" value="<?php echo $_SESSION['thvot_hcode']; ?>">

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="THVOT ระบบการติดตามยาผู้ป่วยวัณโรค">
    <meta name="author" content="Wisnior, Co, Ltd.">
    <title>THVOT : ผู้ป่วย</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../../../tools/dropzone/dist/min/dropzone.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="../../../tools/preload.js/dist/css/preload.css">
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
                        <div class="col-12 col-sm-6 offset-sm-3 dashboard-greetings" id="content-body">
                            <div class="card" style="box-shadow: none;">
                                <div class="card-body pt-1">
                                    <div class="text-center">
                                        <h5>กรุณาใช้ฟังก์ชันนี้เมื่อมีปัญหาในการอัพโหลดเท่านั้ัน</h5>
                                    </div>
                                    <div class="text-center pt-4">
                                        <form method="POST" enctype="multipart/form-data" id="uploadForm" onsubmit="return false;" >

                                            <input type="hidden" id="txtUidUpload" name="txtUidUpload" value="<?php echo $_SESSION['thvot_uid']; ?>">
                                            <input type="hidden" id="txtRoleUpload" name="txtRoleUpload" value="<?php echo $_SESSION['thvot_role']; ?>">
                                            <input type="hidden" id="txtHcodeUpload" name="txtHcodeUpload" value="<?php echo $_SESSION['thvot_hcode']; ?>">
                                            <div class="form-group">
                                                <label for="" class="f500 text-dark">เลือกไฟล์และกดปุ่มอัพโหลด <span class="text-danger">*</span> </label>
                                                <div class="">
                                                    <input id="media" name="media" type="file" class="file_upload form-group">
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <button class="btn btn-danger mt-3 btn-lg btn-block" id="uploadFileAttahed" >อัพโหลดวิดีโอ</button>


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
    <script src="../../../app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/swiper.min.js"></script>
    <script src="../../../tools/dropzone/dist/min/dropzone.min.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="../../../tools/preload.js/dist/js/preload.js"></script>
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
    <!-- <script src="../../../assets/js/scripts/patient_web.js?v=<?php //echo filemtime('../../../assets/js/scripts/patient_web.js'); ?>"></script> -->

    <!-- <script src="../../../app-assets/js/scripts/custom/dashboard-ecommerce.js"></script> -->
    <!-- END: Page JS-->

    <script>

        $file_arr = [];
        var files;

        $(document).ready(function(){
            $w = $('#content-body').width();
            $nw = ($w * 0.5) - 100;
            $('#mydropzone').css('margin-left', $nw + 'px')

            window.localStorage.setItem('thvot_patient_web_uid', $('#txtUid').val())
            window.localStorage.setItem('thvot_patient_web_role', $('#txtRole').val())
            window.localStorage.setItem('thvot_patient_web_hcode', $('#txtHcode').val())

            preload.hide();
        })

        $(function(){
            $('.file_upload').on('change', prepareUpload);
            $('#uploadFileAttahed').on('click', uploadFiles);
        })

        function prepareUpload(event){
            files = event.target.files;
        }

        function uploadFiles(event){
            if ( document.getElementById('media').value.length == 0 ){
                Swal.fire({
                              icon: "error",
                              title: 'เกิดข้อผิดพลาด',
                              text: 'กรุณาเลือกไฟล์วิดีโอ',
                              confirmButtonClass: 'btn btn-danger',
                          })
                return ;
            }

            event.preventDefault();
            // preload.show()

            var formData = new FormData($('#uploadForm')[0]);

            $.each(files, function(key, value)
            {
                $.each(value, function(key, value){
                formData.append(key, value);
                })
            });

            $.ajax({
                xhr: function(){
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e){

                    if(e.lengthComputable){
                        console.log('Byte loaded : ' + e.loaded);
                        console.log('Total size : ' + e.total);
                        console.log('Percentage : ' + (e.loaded / e.total));

                        var percentage = Math.round((e.loaded / e.total) * 100);

                        if(percentage == 100){
                            console.log(JSON.stringify(xhr));
                        }

                        $('#progressUploadBar').attr('aria-valuenow', percentage).css('width', percentage + '%')
                    }
                    })
                    return xhr;
                },
                // url: conf.api + 'staff/upload_file_research_attach_backward.php?files',
                url: "https://thvot.com/thvotweb/app/api/upload_video_backward.php?files",
                type: 'POST',
                data: formData,
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR)
                {
                        console.log('Data -> '.data);
                        console.log('ts -> ' + textStatus);
                        console.log('jxr -> ' + JSON.stringify(jqXHR));
                        // setTimeout(function(){
                        //     window.location.reload()
                        // }, 1000)

                        // $('#media').val('')

                        if(textStatus == 'success'){
                            Swal.fire({
                            icon: "success",
                            title: 'อัพโหลดสำเร็จ',
                            text: 'วิดีโอของท่านถูกอัพโหลดเรียบร้อยแล้ว',
                            confirmButtonClass: 'btn btn-danger',
                        })
                        }
                        return ;
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    preload.hide()
                        // swal({    title: "ไม่สามารถอัพโหลดไฟล์ได้",
                        // text: "กรุณาลองใหม่ หรือส่งไฟล์ให้เจ้าหน้าที่ผ่านทางอีเมล์!",
                        // type: "error",
                        // showCancelButton: false,
                        // confirmButtonColor: "#DD6B55",
                        // confirmButtonText: "รับทราบ",
                        // closeOnConfirm: true },
                        // function(){

                        // });

                        Swal.fire({
                            icon: "error",
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถอัพโหลดได้ กรุณาลองใหม่หรือติดต่อพี่เลี้ยง',
                            confirmButtonClass: 'btn btn-danger',
                        })

                        // Handle errors here
                        console.log('ERRORS: ' + textStatus);
                        console.log('jxr ->' + jqXHR);
                        console.log('ts ->' + textStatus);
                        console.log('errt ->' + errorThrown);
                        setTimeout(function(){
                        $('#progressbar').addClass('dn')
                        }, 1000)
                        $('#progressbar').addClass('dn')
                }
            })
            return ;
            }
    </script>

</body>
<!-- END: Body-->

</html>