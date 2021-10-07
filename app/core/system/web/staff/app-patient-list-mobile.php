<?php 
require('../../../../../../database_config/thvot/config.inc.php');
require('../../../../config/configuration.php');
require('../../../../config/database.php'); 
require('../../../../config/staff.role.php'); 

$db = new Database();
$conn = $db->conn();


$stage = '';
if(isset($_GET['stage'])){ 
    $stage = mysqli_real_escape_string($conn, $_GET['stage']);
}

require('../../../../config/user.inc.php'); 

$menu = 7;

?>
<input type="hidden" id="txtCurrentUid" value="<?php echo $_SESSION['thvot_uid']; ?>">
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
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../../../tools/preload.js/dist/css/preload.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/sweetalert2.min.css">
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
    <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top bg-primary">
        <div class="navbar-wrapper">
            <div class="row">
                <div class="col-2 pl-0">
                    <button class="btn pt-0 text-white" onclick="window.location = './index_mobile'"><i class="bx bx-left-arrow-alt text-white" style="font-size: 2em;"></i></button>
                </div>
                <div class="col-7 th text-white" style="padding-top: 7px;">
                รายชื่อผู้ป่วยทั้งหมด
                </div>
                <div class="col-3 th text-white text-right pr-3" >
                <button class="btn btn-icon round pt-0 text-white" style="margin-right: -20px; background: #06c;"  onclick="window.location = 'app-patient-add-mobile'"><i class="bx bx-plus text-white" style="font-size: 1.4em; padding: 6px 0px;"></i></button>
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
                <!-- users list start -->
                <section class="users-list-wrapper">
                    <div class="users-list-table">
                        <div class="card">
                            <div class="card-body">
                                <!-- datatable start -->
                                <div class="table-responsive">
                                    <table id="users-list-datatable-patient" class="table">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;" class="th"></th>
                                                <!-- <th class="th">บัญชีผู้ใช้งาน</th> -->
                                                <th class="th" style="width: 360px;">ชื่อ - นามสกุล</th>
                                                <th class="th" style="width: 150px;">การติดตาม</th>
                                                <th class="th" style="width: 100px;">สถานะยา</th>
                                                <th class="th" style="width: 100px;">วันที่เริ่มติดตาม</th>
                                                <th class="th" style="width: 100px;">วันสิ้นสุดการติดตาม</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $strSQL = "SELECT a.*, a.ID user_id, b.* , regh.hserv rhserve, obsh.hserv hhserve, menh.hserv mhserve
                                                       FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                                                       LEFT JOIN vot2_projecthospital regh ON a.reg_hcode = regh.phoscode
                                                       LEFT JOIN vot2_projecthospital obsh ON a.reg_hcode = obsh.phoscode
                                                       LEFT JOIN vot2_projecthospital menh ON a.reg_hcode = menh.phoscode
                                                       WHERE 
                                                       a.delete_status = '0' 
                                                       AND b.info_use = '1'
                                                       AND a.role = 'patient'
                                                       AND a.obs_hcode = '".$_SESSION['thvot_hcode']."'
                                            ";
                                            $result_list = $db->fetch($strSQL, true, false);
                                            if($result_list['status']){
                                                $c = 1;
                                                foreach($result_list['data'] as $row){
                                                    ?>
                                                    <tr>
                                                        <td class="text-left" style="vertical-align:top;">
                                                            <a class="btn btn-icon btn-success rounded-circle" style="height: 36px; width: 36px; margin-bottom: 2px;" href="app-patient-management?uid=<?php echo $user['uid']; ?>&role=<?php echo $user['role']; ?>&hcode=<?php echo $user['hcode']; ?>&id=<?php echo $row['uid'];?>" class="mr-1"><i class="bx bx-edit-alt"></i></a>
                                                            <a class="btn btn-icon btn-success rounded-circle" style="height: 36px; width: 36px; margin-bottom: 2px;" href="app-patient-drug?uid=<?php echo $user['uid']; ?>&role=<?php echo $user['role']; ?>&hcode=<?php echo $user['hcode']; ?>&id=<?php echo $row['uid'];?>" class="mr-1"><i class="bx bxs-capsule"></i></a>
                                                            <?php 
                                                            if($row['role'] != 'admin'){
                                                                ?>
                                                                <a class="btn btn-icon btn-outline-danger rounded-circle mb-1" style="height: 36px; width: 36px; margin-bottom: 2px;" href="Javascript:admin_user.delete_user('<?php echo $row['uid'];?>')" clsas=""><i class="bx bx-trash-alt text-danger"></i></a>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <a class="btn btn-icon btn-success-danger rounded-circle mb-1" style="height: 36px; width: 36px; margin-bottom: 2px;" href="#" clsas="" disabled><i class="bx bx-trash-alt text-muted"></i></a>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="th" style="vertical-align:top;">
                                                            <div>ID : <?php echo $row['username']; ?></div>
                                                            <span class="text-dark"><?php echo $row['fname']." ".$row['lname']; ?></span>
                                                            <div  style="padding-top: 4px; font-size: 0.8em; ">
                                                                ลงทะเบียน : <a href="Javascript:void(0);"><?php if($row['rhserve'] != null){ echo $row['rhserve'];} else { echo "-"; }; ?></a><br>
                                                                ติดตามรักษา : <a href="Javascript:void(0);"><?php if($row['rhserve'] != null){ echo $row['mhserve'];} else { echo "-"; }; ?></a><br>
                                                                พี่เลี้ยง : <a href="Javascript:void(0);"><?php if($row['rhserve'] != null){ echo $row['hhserve'];} else { echo "-"; }; ?></a>
                                                            </div>
                                                            <div class="" style="padding-top: 4px;">
                                                            <?php 
                                                            $ptt = $row['patient_type'];
                                                            if($row['patient_type'] == 'DOT'){
                                                                ?>
                                                                <span class="badge badge-warning"><?php echo $ptt; ?></span>
                                                                <?php
                                                            }else if($row['patient_type'] == 'VOT'){
                                                                ?>
                                                                <span class="badge badge-primary"><?php echo $ptt; ?></span>
                                                                <?php
                                                            }
                                                            
                                                            ?>
                                                            </div>
                                                        </td>
                                                        <td class="th" style="vertical-align:top;">
                                                            <?php 
                                                            if($row['stop_drug'] == '1'){
                                                                ?>
                                                                <i class="bx bxs-circle text-danger"></i> หยุดยา/หยุดติดตาม
                                                                <div>
                                                                    <span class="btn btn-light-warning btn-sm round th" style="cursor: pointer; margin-top: 5px;" onclick="back2Follow('<?php echo $row['uid']; ?>', '<?php echo $row['fname']." ".$row['lname']; ?>')">กลับมาติดตาม</span>
                                                                </div>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <i class="bx bxs-circle text-success"></i> กำลังติดตาม
                                                                <div>
                                                                    <span class="btn btn-light-danger btn-sm round th" style="cursor: pointer; margin-top: 5px;" onclick="window.location='app-patient-calendar?uid=<?php echo $_SESSION['thvot_uid']; ?>&role=<?php echo $_SESSION['thvot_role']; ?>&hcode=<?php echo $_SESSION['thvot_hcode']; ?>&id=<?php echo $row['uid']; ?>'">สั่งหยุดยา</span>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="th" style="vertical-align:top; width: 100px;">
                                                            <?php 
                                                            $strSQL = "SELECT * FROM vot2_med_transaction WHERE mt_patient_uid = '".$row['uid']."' AND mt_status = 'Y' LIMIT 1";
                                                            $resCheckDrug = $db->fetch($strSQL, true, true);
                                                            if(($resCheckDrug) && ($resCheckDrug['count'] > 0)){
                                                                ?>
                                                                <i class="bx bxs-circle text-success"></i> ยืนยันแล้ว
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <i class="bx bxs-circle text-danger"></i> ยังไม่ยืนยัน
                                                                <div>
                                                                    <span class="btn btn-light-danger btn-sm round th" style="cursor: pointer; margin-top: 5px;" onclick="window.location='app-patient-drug?uid=<?php echo $_SESSION['thvot_uid']; ?>&role=<?php echo $_SESSION['thvot_role']; ?>&hcode=<?php echo $_SESSION['thvot_hcode']; ?>&id=<?php echo $row['uid']; ?>'">ไปยืนยัน</span>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="th" style="vertical-align:top;"><?php echo $row['start_obsdate']; ?></td>
                                                        <td class="th" style="vertical-align:top;"><?php echo $row['end_obsdate']; ?></td>
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
    <script src="../../../app-assets/js/scripts/pages/app-users.js?v=<?php echo filemtime('../../../app-assets/js/scripts/pages/app-users.js'); ?>"></script>
    <script src="../../../assets/js/scripts/admin-user.js?v=<?php echo filemtime('../../../assets/js/scripts/admin-user.js'); ?>"></script>
    <script src="../../../assets/js/scripts/patient.js?v=<?php echo filemtime('../../../assets/js/scripts/patient.js'); ?>"></script>
    <!-- END: Page JS-->
    <script>
        $(document).ready(function(){
            preload.hide();

            if ($("#users-list-datatable-patient").length > 0) {
                usersTable = $("#users-list-datatable-patient").DataTable({
                    responsive: true,
                    'columnDefs': [
                        {
                            "orderable": false,
                            "targets": [0, 2, 3, 4]
                        }]
                });
            };
        })

        function back2Follow(puid, pname){
            Swal.fire({
                title: 'ยืนยันดำเนินการ',
                text: 'ท่านยืนยันการกลับมาติดตามของคุณ ' + pname + ' หรือไม่',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                confirmButtonClass: 'btn btn-primary mr-1',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            }).then(function (result) {
                if (result.value) {
                    preload.show()
                    var param = {
                        puid: puid,
                        uid: $('#txtCurrentUid').val()
                    }

                    var jxr = $.post(api_url + 'patient?stage=back2follow', param, function(){}, 'json')
                               .always(function(snap){
                                   console.log(snap);
                                   return ;
                                    preload.hide()
                                    if(snap.status == 'Success'){

                                    }else{

                                    }
                               })
                }
            })
        }
    </script>
</body>
<!-- END: Body-->

</html>