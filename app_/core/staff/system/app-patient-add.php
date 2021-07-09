<?php 
require('../../../../../database_config/thvot/config.inc.php');
require('../../../config/configuration.php');
require('../../../config/database.php'); 
require('../../../config/staff.role.php'); 
$db = new Database();
$conn = $db->conn();

$stage = '';
if(isset($_GET['stage'])){ 
    $stage = mysqli_real_escape_string($conn, $_GET['stage']);
}

require('../../../config/user.inc.php'); 

$menu = 12;
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
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
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
                        require("../../control/notification.php");
                        require("../../control/profile_menu.php");
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
                <li class="nav-item mr-auto"><a class="navbar-brand" href="../../../html/ltr/vertical-menu-template/index">
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
                        <h2 class="brand-text mb-0">Frest</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <?php require("../../control/admin-menu.php"); ?>
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
            <h2 class="mb-2">เพิ่มผู้ป่วยใหม่</h2>
                <!-- users edit start -->
                <div class="row">
                    <div class="col-12 pb-1">
                        <button class="btn btn-primary" onclick="window.location = 'app-patient-list'"><i class="bx bx-list-ul"></i> รายชื่อผู้ป่วยติดตาม</button>
                    </div>
                </div>
                <section class="users-edit">
                    <div class="card">
                        <div class="card-body">
                            <!-- users edit account form start -->
                                    <form class="patientaddform" onsubmit="return admin_user.check_patientadd_form()" method="post" action="../../../controller/user?stage=create_patient">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="text-bold-600">ข้อมูลเบื้องต้นและบัญชีการใช้งานของผู้ป่วย</h5>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <div class="row">
                                                    <div class="col-3" style="display: none;">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>Prefix (เฉพาะผู้ป่วย)</label>
                                                                <input type="text" class="form-control" placeholder=""  name="txtPrefix" id="txtPrefix" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>TB NO. (ใน NTIP) : <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" placeholder="" id="txtUsername" name="txtUsername" >
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>HN : <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" placeholder="" id="txtHn" name="txtHn" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>ตั้งรหัสผ่าน : <span class="text-danger">*</span></label>
                                                                <input type="password" class="form-control" placeholder="" id="txtPassword1" name="txtPassword1" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label>ยืนยันรหัสผ่าน : <span class="text-danger">*</span></label>
                                                                <input type="password" class="form-control" placeholder="" id="txtPassword2" name="txtPassword2" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-6">
                                                            <div class="controls">
                                                                <label>ชื่อ : <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Name" name="txtFname" id="txtFname">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="controls">
                                                                <label>นามสกุล : <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Surname"  name="txtLname" id="txtLname">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <label>หมายเลขโทรศัพท์ : <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="Phone number" name="txtPhone" id="txtPhone">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label>หน่วย/สถานบริการ : <span class="text-danger">*</span></label>
                                                    <div class="select-error">
                                                        <select name="txtHcode" id="txtHcode" data-required class="form-control select2">
                                                            <option value="">-- เลือกหน่วยบริการ --</option>
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
                                                <div class="form-group">
                                                    <label>ประเภทการติดตาม : <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="txtRole" name="txtRole">
                                                        <option value="">-- เลือกประเภท --</option>
                                                        <option value="VOT">VOT</option>
                                                        <option value="DOT">DOT</option>
                                                        <option value="TESTER">TESTER</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>สถานะการใช้งาน : <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="txtStatus" name="txtStatus">
                                                        <option value="" selected>-- เลือกสถานะ --</option>
                                                        <option value="1">เปิดใช้งาน</option>
                                                        <option value="0">ปิดใช้งาน</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>สถานะการตรวจสอบบัญชีผู้ใช้ : <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="txtVerify" name="txtVerify">
                                                        <option value="" selected>-- เลือกสถานะ --</option>
                                                        <option value="1">ยืนยันแล้ว</option>
                                                        <option value="0">รอการยืนยัน</option>
                                                    </select>
                                                </div>
                                                
                                            </div>

                                            <div class="col-12">
                                                <hr>
                                                <h5 class="text-bold-600">ที่อยู่ของผู้ป่วย</h5>
                                                <div class="row">
                                                    <div class="form-group col-12 col-sm-4">
                                                        <label>จังหวัด : <span class="text-danger">*</span></label>
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

                                                    <div class="form-group col-12 col-sm-4">
                                                        <label>อำเภอ : <span class="text-danger">*</span></label>
                                                        <select id="txtDist" name="txtDist" class="form-control">
                                                            <option value="">-- เลือกอำเภอ --</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-12 col-sm-4">
                                                        <label>ตำบล : <span class="text-danger">*</span></label>
                                                        <select id="txtSubdist" name="txtSubdist" class="form-control">
                                                            <option value="">-- เลือกตำบล --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                                <!-- <button type="button" onclick="admin_user.check_add_form()" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">บันทึก</button> -->
                                                <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1" style="display-: none;">บันทึก</button>
                                                <button type="reset" class="btn btn-light">รีเซ็ต</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- users edit account form ends -->
                        </div>
                    </div>
                </section>
                <!-- users edit ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <?php 
    require("../../control/footer.php");
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
    <script src="../../../app-assets/js/scripts/pages/app-users.js"></script>
    <script src="../../../assets/js/scripts/admin-user.js?v=<?php echo filemtime('../../../assets/js/scripts/admin-user.js'); ?>"></script>
    <!-- END: Page JS-->
    <script>
        $(document).ready(function(){
            $(".select2").select2({
            dropdownAutoWidth: true,
            width: '100%'
            });

            $stage = '<?php echo $stage;?>'
            if($stage == 'duplicate'){
                Swal.fire(
                {
                  icon: "error",
                  title: 'เกิดข้อผิดพลาด',
                  text: 'บัญชีผู้ใช้งานถูกใช้งานแล้ว',
                  confirmButtonClass: 'btn btn-danger',
                }
              )
            }else if($stage == 'fail'){
                Swal.fire(
                {
                  icon: "error",
                  title: 'เกิดข้อผิดพลาด',
                  text: 'ไม่สามารถสร้างบัญชีผู้ใช้งานได้',
                  confirmButtonClass: 'btn btn-danger',
                }
              )
            }else if($stage == 'fail_create'){
                Swal.fire(
                {
                  icon: "error",
                  title: 'เกิดข้อผิดพลาด',
                  text: 'ไม่สามารถสร้างบัญชีผู้ใช้งานได้',
                  confirmButtonClass: 'btn btn-danger',
                }
              )
            }else if($stage == 'success'){
                Swal.fire(
                {
                  icon: "success",
                  title: 'สำเร็จ',
                  text: 'บัญชีผู้ใช้งานถูกสร้างเรียบร้อยแล้ว',
                  confirmButtonClass: 'btn btn-danger',
                }
              )
            }
        })

        $(function(){

            $('#txtUsername').blur(function(){
                if(($('#txtUsername').val() != '') && ($('#txtRole').val() != '')){
                    $hcode = $('#txtHcode').select2('val')
                    var param = {
                        username: $('#txtUsername').val(), 
                        role: $('#txtRole').val(), 
                        hcode: $hcode
                    }
                    var jxr = $.post('../../../api/admin-api?stage=checkuser', param, function(){})
                                .always(function(resp){
                                    console.log(resp);
                                    if(resp != 'Success'){
                                        Swal.fire(
                                            {
                                              icon: "error",
                                              title: 'คำเตือน',
                                              text: 'บัญชีผู้ใช้งานนี้ถูกใช้งานแล้ว',
                                              confirmButtonClass: 'btn btn-danger',
                                            }
                                          )
                                        return false;
                                    }
                                })
                }
            })

            $('#txtRole').change(function(){
                if(($('#txtUsername').val() != '') && ($('#txtRole').val() != '')){
                    $hcode = $('#txtHcode').select2('val')
                    var param = {
                        username: $('#txtUsername').val(), 
                        role: $('#txtRole').val(), 
                        hcode: $hcode
                    }
                    var jxr = $.post('../../../api/admin-api?stage=checkuser', param, function(){})
                                .always(function(resp){
                                    console.log(resp);
                                    if(resp != 'Success'){
                                        Swal.fire(
                                            {
                                              icon: "error",
                                              title: 'คำเตือน',
                                              text: 'บัญชีผู้ใช้งานนี้ถูกใช้งานแล้ว',
                                              confirmButtonClass: 'btn btn-danger',
                                            }
                                          )
                                        return false;
                                    }
                                })
                }
            })

            $('#txtProvince').change(function(){
                $('#txtDist').empty()
                $('#txtSubdist').empty()

                $('#txtDist').append('<option value="">-- เลือกอำเภอ --</option>')
                $('#txtSubdist').append('<option value="">-- เลือกตำบล --</option>')

                var jxt = $.post('../../../api/core-api?stage=district', {province : $('#txtProvince').val()}, function(){}, 'json')
                        .always(function(snap){
                            if(snap.status == 'Success'){
                            snap.data.forEach(i => {
                                $('#txtDist').append('<option value="' + i.Ampur + '">' + i.Name + '</option>')
                            });
                            }
                        })
                })

            $('#txtDist').change(function(){
                $('#txtSubdist').empty()
                $('#txtSubdist').append('<option value="">-- เลือกตำบล --</option>')

                var jxt = $.post('../../../api/core-api?stage=subdistrict', {province : $('#txtProvince').val(), dist: $('#txtDist').val() }, function(){}, 'json')
                        .always(function(snap){
                            console.log(snap);
                            if(snap.status == 'Success'){
                            snap.data.forEach(i => {
                                $('#txtSubdist').append('<option value="' + i.Tumbon + '">' + i.Name + '</option>')
                            });
                            }
                        })
             })
            
        })

    </script>
</body>
<!-- END: Body-->

</html>