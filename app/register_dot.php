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

$uid = '';
if(!isset($_GET['uid'])){ 
    $db->close();
   header('Location: ./404.php');
}

$uid = mysqli_real_escape_string($conn, $_GET['uid']);
$photo = mysqli_real_escape_string($conn, $_GET['photo']);

header('Location: ./register_patient?uid=' . $token . '&referal=webapp&photo='.$photo);

// $strSQL = "SELECT * FROM vot2_account WHERE uid = '$uid' AND role = 'patient'";
// $res = $db->fetch($strSQL, true, true);


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
    <title>THVOT : DOT Register</title>
    <link rel="apple-touch-icon" href="../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/extensions/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/forms/select/select2.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/themes/semi-dark-layout.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/pages/authentication.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
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
                <!-- register section starts -->
                <section class="row flexbox-container">
                    <div class="col-xl-8 col-12">
                        <div class="card bg-authentication mb-0">
                            <div class="row m-0">
                                <!-- register section left -->
                                <div class="col-md-6 col-12 px-0">
                                    <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h3 class="text-left mb-1">THVOT</h3>
                                                <h4 class="text-left mb-1">ลงทะเบียนผู้ป่วย DOT</h4>
                                                <!-- <h6 class="text-danger">กรุณากรอกข้อมูลให้ครบถ้วน</h6> -->
                                                <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <div class="d-flex align-items-center">
                                                        <span>
                                                        กรุณากรอกข้อมูลให้ครบถ้วน
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form  action="./controller/auth?stage=signup_dot" method="POST" autocomplete="off"  onsubmit="return auth.chk_register_dot();">

                                                <div class="form-group mb-50" style="display: none;">
                                                    <label class="text-bold-600" for="exampleInputPassword1">UID :</label>
                                                    <input type="text" class="form-control" id="txtUid" name="txtUid" value="<?php echo $uid; ?>">
                                                </div>

                                                <div class="form-group mb-50" style="display: none;">
                                                    <label class="text-bold-600" for="exampleInputPassword1">Photo :</label>
                                                    <input type="text" class="form-control" id="txtPhoto" name="txtPhoto" value="<?php echo $photo; ?>">
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6 mb-50">
                                                        <label for="inputfirstname4">ชื่อ :  <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="txtFname" name="txtFname">
                                                    </div>
                                                    <div class="form-group col-md-6 mb-50">
                                                        <label for="inputlastname4">นามสกุล : <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="txtLname" name="txtLname">
                                                    </div>
                                                </div>

                                                <div class="form-group mb-50">
                                                    <label class="" for="exampleInputPassword1">TB NO. (ใน NTIP) : <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="txtHn" name="txtHn">
                                                </div>

                                                <div class="form-group mb-50">
                                                    <label class="" for="exampleInputEmail1">หมายเลขโทรศัพท์ : <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="txtPhone" name="txtPhone" placeholder="">
                                                </div>

                                                <hr>

                                                <h6 class="text-bold-600">ที่อยู่ผู้ป่วย</h6>

                                                <div class="form-group mb-50">
                                                    <label class="" for="exampleInputPassword1">จังหวัดที่อยู่ : <span class="text-danger">*</span></label>
                                                    <div>
                                                        <select id="txtProvince" name="txtProvince" class="form-control">
                                                            <option value="">-- เลือกจังหวัด --</option>
                                                            <?php 
                                                            $strSQL = "SELECT * FROM vot2_changwat 
                                                            WHERE Changwat in (SELECT ap_code FROM vot2_active_province WHERE 1) ORDER BY Name ASC";
                                                            $result_list = $db->fetch($strSQL, true, false);
                                                            if($result_list['status']){
                                                                $c = 1;
                                                                foreach($result_list['data'] as $row){
                                                                    ?>
                                                                    <option value="<?php echo $row['Changwat'];?>" <?php  ?>>[<?php echo $row['Changwat'];?>] <?php echo $row['Name'];?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-50">
                                                    <label class="" for="exampleInputPassword1">อำเภอ : <span class="text-danger">*</span></label>
                                                    <div>
                                                        <select id="txtDist" name="txtDist" class="form-control">
                                                            <option value="">-- เลือกอำเภอ --</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-50">
                                                    <label class="" for="exampleInputPassword1">ตำบล : <span class="text-danger">*</span></label>
                                                    <div>
                                                        <select id="txtSubdist" name="txtSubdist" class="form-control">
                                                            <option value="">-- เลือกตำบล --</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <hr>

                                                <h6 class="text-bold-600">สถานบริการสุขภาพ</h6>

                                                <div class="form-group mb-50">
                                                    <label class="" for="exampleInputPassword1">สถานบริการสุขภาพ : <span class="text-danger">*</span></label>
                                                    <div class="select-error">
                                                        <select name="txtHcode" id="txtHcode" data-required class="form-control select2">
                                                            <option value="">-- สถานบริการสุขภาพ --</option>
                                                            <?php 
                                                            $strSQL = "SELECT vot2_projecthospital.* FROM vot2_projecthospital 
                                                            WHERE phosstatus = 'Y' ORDER BY hserv";
                                                            $result_list = $db->fetch($strSQL, true, false);
                                                            if($result_list['status']){
                                                                $c = 1;
                                                                foreach($result_list['data'] as $row){
                                                                    ?>
                                                                    <option value="<?php echo $row['phoscode'];?>" <?php  ?>>[<?php echo $row['phoscode'];?>] <?php echo $row['hserv'];?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <button type="submit" class="mt-1 btn btn-primary glow position-relative w-100">ลงทะเบียน<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- image section right -->
                                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                                    <img class="img-fluid" src="../app-assets/images/pages/register.png" alt="branding logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- register section endss -->

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="../app-assets/vendors/js/vendors.min.js"></script>
    <script src="../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
    <script src="../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
    <script src="../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <script src="../app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="../app-assets/vendors/js/extensions/polyfill.min.js"></script>
    <script src="../app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../app-assets/js/scripts/configs/vertical-menu-light.js"></script>
    <script src="../app-assets/js/core/app-menu.js"></script>
    <script src="../app-assets/js/core/app.js"></script>
    <script src="../app-assets/js/scripts/components.js"></script>
    <script src="../app-assets/js/scripts/footer.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="../assets/js/scripts/authen.js?v=<?php echo filemtime('./assets/js/scripts/authen.js'); ?>"></script>
    <!-- END: Page JS-->

    <script>
        $(document).ready(function(){
            $(".select2").select2({
            dropdownAutoWidth: true,
            width: '100%'
            });
        })
    </script>

</body>
<!-- END: Body-->

</html>