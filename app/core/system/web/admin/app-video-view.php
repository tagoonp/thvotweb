<?php 
require('../../../../config/config.inc.php');
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

$menu = 8;

if(
    (!isset($_GET['id'])) ||
    (!isset($_GET['vid'])) ||
    (!isset($_GET['uid'])) ||
    (!isset($_GET['hcode']))
){
    $db->close();
    header('Location: ./app-video-wait');
    die();
}

$patient_id = mysqli_real_escape_string($conn, $_GET['id']);
$video_id = mysqli_real_escape_string($conn, $_GET['vid']);

$strSQL = "SELECT * FROM vot2_account a INNER JOIN vot2_userinfo b ON a.username = b.info_username
           WHERE 
           a.delete_status = '0' 
           AND a.active_status = '1'
           AND b.info_use = '1'
           AND a.uid = '$patient_id'
           ORDER BY a.ID DESC LIMIT 1
          ";
$resPatient = $db->fetch($strSQL, false);
if(!$resPatient){
    $db->close();
    header('Location: ./app-video-wait');
    die();
}

$strSQL = "SELECT * FROM vot2_followup
           WHERE 
           fu_id = '$video_id ' 
           AND fu_uid = '$patient_id'
          ";
$resVideo = $db->fetch($strSQL, false);
if(!$resVideo){
    $db->close();
    header('Location: ./app-video-wait');
    die();
}

$next24time = date("Y-m-d H:i:s", strtotime($resVideo['fu_upload_datetime'] . " +25 hours"));
?>
<input type="hidden" id="txtCurrentUid" value="<?php echo $_SESSION['thvot_uid']; ?>">
<input type="hidden" id="txtCurrentUhcode" value="<?php echo $_SESSION['thvot_hcode']; ?>">
<input type="hidden" id="txtCurrentPid" value="<?php echo $patient_id; ?>">
<input type="hidden" id="txtCurrentVid" value="<?php echo $video_id; ?>">
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
            <section class="users-list-wrapper">
                    <div class="users-list-table">
                        <h3>ตรวจสอบการรับประทานยา</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./"><i class="bx bx-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="./app-patient-list" class="text-primary">รายชื่อผู้ป่วย</a></li>
                            <li class="breadcrumb-item" aria-current="page">ตรวจสอบวิดีโอ</li>
                            </ol>
                        </nav>
                        <div class="card" style="box-shadow: none;">
                            <div class="row">
                                    <div class="col-12 col-sm-5">
                                        <video width="100%" controls autoplay>
                                            <source src="<?php echo $resVideo['fu_video']; ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                    <div class="col-12 col-sm-7">
                                        <div class="p-2">


                                        <h4 class="mb-1">ข้อมูลผู้ป่วย : </h4>
                                        <div>
                                            <span class="badge badge-light-success round"><?php echo $resPatient['username']; ?></span>
                                            <div class="row">
                                                <div class="col-12"><h3 class="mt-1"><?php echo $resPatient['fname']." ".$resPatient['lname'];  ?></h3></div>
                                                <div class="col-12 pt-1 text-left">
                                                    <a class="btn btn-secondary round" href="app-patient-management?uid=<?php echo $_SESSION['thvot_uid']; ?>&role=<?php echo $_SESSION['thvot_role']; ?>&hcode=<?php echo $_SESSION['thvot_hcode']; ?>&id=<?php echo $patient_id; ?>"><i class="bx bx-pencil"></i> ดูข้อมูลผู้ป่วย</a>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <h4 class="mb-1">ส่วนที่ 1 : <br><small>จำนวนยาที่รับประทาน</small></h4>
                                        <?php 
                                        $strSQL = "SELECT * FROM vot2_patient_med WHERE med_pid = '$patient_id' AND med_cnf = 'Y' ORDER BY med_name";
                                        $resMed = $db->fetch($strSQL, true);
                                        if(($resMed) && ($resMed['status'])){
                                            $c = 1;
                                            foreach ($resMed['data'] as $rowMed) {

                                                $strSQL = "SELECT SUM(mt_med_take) as sm FROM vot2_patient_med_take 
                                                           WHERE 
                                                           mt_med_id = '".$rowMed['ID']."' 
                                                           AND mt_med_name = '".$rowMed['med_name']."'
                                                           AND mt_cnf = 'Y'
                                                           AND mt_vid IN (
                                                               SELECT fu_id FROM vot2_followup WHERE fu_date IN (
                                                                   SELECT fu_date FROM vot2_followup WHERE fu_id = '$video_id'
                                                               )
                                                           )
                                                           ";
                                                $resMt = $db->fetch($strSQL, false);
                                                // echo $strSQL;
                                                $taken = 0;
                                                if(($resMt) && ($resMt['sm'] != null)){
                                                    $taken = $resMt['sm'];
                                                }
                                                // echo $strSQL;

                                                ?>
                                                <div class="row mb-0">
                                                     <div class="col-9">
                                                        <?php echo $rowMed['med_name']; ?>
                                                        <div><span class="text-danger">วันนี้ยังต้องกินอีก <?php echo $rowMed['med_amount'] - $taken; ?> เม็ด</span></div>
                                                        <input type="hidden" id="txtMedId_<?php echo $c; ?>" value="<?php echo $rowMed['ID']; ?>">
                                                        <input type="hidden" id="txtMedName_<?php echo $c; ?>" value="<?php echo $rowMed['med_name']; ?>">
                                                    </div>
                                                    <div class="col-3 text-left pr-0" style="padding-top: 0px;">
                                                        <?php 
                                                        if($resVideo['fu_status'] != 'complete'){
                                                            if($datetime < $next24time){
                                                                ?>
                                                                <fieldset class="form-group">
                                                                    <select class="form-control" id="txtMedQ_<?php echo $c; ?>" onchange="setDrugTake('<?php echo $c; ?>')">
                                                                        <option value="">ระบุ</option>
                                                                        <?php 
                                                                        if($rowMed['med_amount'] != null){
                                                                            for ($i=0; $i <= ($rowMed['med_amount'] - $taken) ; $i++) { 
                                                                                ?>
                                                                                <option><?php echo $i; ?></option>
                                                                                <?php
                                                                            }
                                                                        }else{
                                                                            ?>
                                                                            <option value="0"><?php echo "0"; ?></option>
                                                                            <?php
                                                                        }
                                                                        
                                                                        ?>
                                                                    </select>
                                                                </fieldset>
                                                                <?php
                                                            }
                                                           
                                                        }else{
                                                            $strSQL = "SELECT mt_med_take FROM vot2_patient_med_take WHERE mt_med_name = '".$rowMed['med_name']."' AND mt_vid = '$video_id'";
                                                            $resPrev = $db->fetch($strSQL, false);
                                                            if($resPrev){
                                                                echo "ทานครั้งนี้ " . $resPrev['mt_med_take'] . " เม็ด";
                                                            }else{
                                                                echo "ทานครั้งนี้ " . "0 เม็ด";
                                                            }
                                                        }
                                                        ?>
                                                        
                                                    </div>
                                                </div>
                                                <?php
                                                $c++;
                                            }
                                        }else{
                                            // echo $strSQL;
                                            ?>
                                            <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                                                <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button> -->
                                                <div class="d-flex align-items-center">
                                                <i class="bx bx-error"></i>
                                                <span>
                                                    ไม่พบรายการยาที่ยืนยันแล้วของผู้ป่วยรายนี้
                                                </span>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <hr>
                                        <h4 class="mb-1">ส่วนที่ 2 : <br><small>ความถูกต้องของวิธีการกินยา</small></h4>
                                        <div class="row mb-1">
                                            <div class="col-2 text-left pr-0" style="padding-top: 3px;">
                                                <div class="custom-control custom-switch custom-switch-success mr-1 mb-1">
                                                    <input type="checkbox" class="custom-control-input" id="checklist1" <?php if($resVideo['fu_checklist1'] == 'Y'){ echo "checked"; } ?>>
                                                    <label class="custom-control-label" for="checklist1">
                                                        <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                            เห็นเม็ดยาตั้งแต่หยิบจากแผ่นแยกแยะยาจนถึงการวางไว้บนลิ้น
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-2 text-left pr-0" style="padding-top: 3px;">
                                                <div class="custom-control custom-switch custom-switch-success mr-1 mb-1">
                                                    <input type="checkbox" class="custom-control-input" id="checklist2" <?php if($resVideo['fu_checklist2'] == 'Y'){ echo "checked"; } ?>>
                                                    <label class="custom-control-label" for="checklist2">
                                                        <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                            อ้าปากเห็นเม็ดยาชัดเจนก่อนกลืนยา
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-2 text-left pr-0" style="padding-top: 3px;">
                                                <div class="custom-control custom-switch custom-switch-success mr-1 mb-1">
                                                    <input type="checkbox" class="custom-control-input" id="checklist3" <?php if($resVideo['fu_checklist3'] == 'Y'){ echo "checked"; } ?>>
                                                    <label class="custom-control-label" for="checklist3">
                                                        <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                            ตอนกลืนยาดื่มน้ำด้วยแก้วน้ำใส
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <div class="col-2 text-left pr-0" style="padding-top: 3px;">
                                                <div class="custom-control custom-switch custom-switch-success mr-1 mb-1">
                                                    <input type="checkbox" class="custom-control-input" id="checklist4" <?php if($resVideo['fu_checklist4'] == 'Y'){ echo "checked"; } ?>>
                                                    <label class="custom-control-label" for="checklist4">
                                                        <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                            หลังกลืนยาทุกครั้งอ้าปากกระดกลิ้นขึ้น และแลบลิ้นลง
                                            </div>
                                        </div>
                                        <hr>

                                        <h4 class="mb-1">ส่วนที่ 3 : <br><small>ผลข้างเคียง</small></h4>

                                        <div class="row mb-0">
                                            <div class="col-2 text-left pr-0" style="padding-top: 3px;">
                                                <div class="custom-control custom-switch custom-switch-success mr-1 mb-1">
                                                    <input type="checkbox" class="custom-control-input" id="eff1" <?php if($resVideo['fu_eff1'] == '1'){ echo "checked"; } ?>>
                                                    <label class="custom-control-label" for="eff1">
                                                        <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                ปวดบวม บริเวณใบหน้าหรือตามข้อ
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-2 text-left pr-0" style="padding-top: 3px;">
                                                <div class="custom-control custom-switch custom-switch-success mr-1 mb-1">
                                                    <input type="checkbox" class="custom-control-input" id="eff2" <?php if($resVideo['fu_eff2'] == '1'){ echo "checked"; } ?>>
                                                    <label class="custom-control-label" for="eff2">
                                                        <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                เหน็บชา/ปวดแสบ บริเวณปลายมือปลายเท้า
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-2 text-left pr-0" style="padding-top: 3px;">
                                                <div class="custom-control custom-switch custom-switch-success mr-1 mb-1">
                                                    <input type="checkbox" class="custom-control-input" id="eff3" <?php if($resVideo['fu_eff3'] == '1'){ echo "checked"; } ?>>
                                                    <label class="custom-control-label" for="eff3">
                                                        <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                มีผื่น/ผื่นคันตามตัว
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-2 text-left pr-0" style="padding-top: 3px;">
                                                <div class="custom-control custom-switch custom-switch-success mr-1 mb-1">
                                                    <input type="checkbox" class="custom-control-input" id="eff4" <?php if($resVideo['fu_eff4'] == '1'){ echo "checked"; } ?>>
                                                    <label class="custom-control-label" for="eff4">
                                                        <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                ปวดศีรษะ/วิงเวียน
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-2 text-left pr-0" style="padding-top: 3px;">
                                                <div class="custom-control custom-switch custom-switch-success mr-1 mb-1">
                                                    <input type="checkbox" class="custom-control-input" id="eff5" <?php if($resVideo['fu_eff5'] == '1'){ echo "checked"; } ?>>
                                                    <label class="custom-control-label" for="eff5">
                                                        <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                ไข้/หนาวสั่น โดยไม่มีน้ำมูก
                                            </div>
                                        </div>

                                        <div class="row  mb-0">
                                            <div class="col-2 text-left pr-0" style="padding-top: 3px;">
                                                <div class="custom-control custom-switch custom-switch-success mr-1 mb-1">
                                                    <input type="checkbox" class="custom-control-input" id="eff6" <?php if($resVideo['fu_eff6'] == '1'){ echo "checked"; } ?>>
                                                    <label class="custom-control-label" for="eff6">
                                                        <span class="switch-icon-left"><i class="bx bx-check"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-10">
                                                อ่อนเพลีย ไม่อยากอาหาร
                                            </div>
                                        </div>

                                        <div class="row  mb-0">
                                            <div class="col-12" style="padding-top: 3px;">
                                                <div class="form-group">
                                                    <textarea name="txtOthereff" id="txtOthereff" cols="30" rows="10" class="form-control" placeholder="อื่น ๆ (เว้นว่างถ้าไม่มี)" style="height: 80px;"><?php echo $resVideo['fu_eff_other']; ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-sm-6 pt-1">
                                            <?php 
                                            if($resVideo['fu_status'] != 'complete'){
                                                
                                                if($datetime <= $next24time){
                                                    ?><button class="btn btn-danger round btn-block" onclick="saveCheckVideo()" type="button">บันทึกผล</button><?php
                                                }
                                            }
                                            ?>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                        </div>
                    </div>
                </section>

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
                            "targets": [0, 2, 3]
                        }]
                });
            };
        })

        function setDrugTake(rid){
            var param = {
                did: $('#txtMedId_' + rid).val(),
                dname: $('#txtMedName_' + rid).val(),
                dq: $('#txtMedQ_' + rid).val(),
                vid: $('#txtCurrentVid').val(),
                pusername: '<?php echo $resPatient['username']; ?>'
            }

            console.log(param);
            // return ;

            var jxr = $.post(api_url + 'patient?stage=takedrug', param, function(){}, 'json')
                       .always(function(snap){ console.log(snap); })
        }

        function saveCheckVideo(){
            Swal.fire({
                title: 'คำเตือน !!!',
                text: 'โปรดตรวจสอบข้อมูลให้เรียบร้อยก่อนบันทึกข้อมูล เนื่องจากท่านจะไม่สามารถแก้ไขข้อมูลที่บันทึกไปแล้วได้ หากมีความผิดพลาดในการลงข้อมูล',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ยืนยันการบันทึกข้อมูล',
                cancelButtonText: 'ตรวจสอบข้อมูลอีกครั้ง',
                confirmButtonClass: 'btn btn-primary mb-sm-0 mb-1 mr-sm-1 mr-0',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            }).then(function (result) {
                if (result.value) {
                    preload.show()
                    $chk1 = 'N'; $chk2 = 'N'; $chk3 = 'N';  $chk4 = 'N';
                    $eff1 = 0; $eff2 = 0; $eff3 = 0;  $eff4 = 0;  $eff5 = 0;  $eff6 = 0;

                    if ($('#checklist1').is(':checked')) { $chk1 = 'Y'; }
                    if ($('#checklist2').is(':checked')) { $chk2 = 'Y'; }
                    if ($('#checklist3').is(':checked')) { $chk3 = 'Y'; }
                    if ($('#checklist4').is(':checked')) { $chk4 = 'Y'; }

                    if ($('#eff1').is(':checked')) { $eff1 = 1; }
                    if ($('#eff2').is(':checked')) { $eff2 = 1; }
                    if ($('#eff3').is(':checked')) { $eff3 = 1; }
                    if ($('#eff4').is(':checked')) { $eff4 = 1; }
                    if ($('#eff5').is(':checked')) { $eff5 = 1; }
                    if ($('#eff6').is(':checked')) { $eff6 = 1; }

                    var param = {
                        puid: $('#txtCurrentPid').val(),
                        check1: $chk1,
                        check2: $chk2,
                        check3: $chk3,
                        check4: $chk4,
                        eff1: $eff1,
                        eff2: $eff2,
                        eff3: $eff3,
                        eff4: $eff4,
                        eff5: $eff5,
                        eff6: $eff6,
                        effother: $('#txtOthereff').val(),
                        uid: $('#txtCurrentUid').val(),
                        uhcode: $('#txtCurrentUhcode').val(),
                        vid: $('#txtCurrentVid').val()
                    }

                    // console.log(param);
                    // return ;

                    var jxr = $.post(api_url + 'patient?stage=videocheck', param, function(){}, 'json')
                               .always(function(snap){
                                   console.log(snap);
                                    preload.hide()
                                    if(snap.status == 'Success'){
                                        // window.location = 'closeinapp.php'
                                        Swal.fire({
                                            title: 'สำเร็จ',
                                            text: 'วิดีโอได้ถูกตรวจสอบเรียบร้อยแล้ว',
                                            icon: 'warning',
                                            showCancelButton: false,
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'รับทราบ',
                                            // cancelButtonText: 'ตรวจสอบข้อมูลอีกครั้ง',
                                            confirmButtonClass: 'btn btn-primary mb-1 mb-sm-0 mr-sm-1 mr-0',
                                            cancelButtonClass: 'btn btn-danger',
                                            buttonsStyling: false,
                                        }).then(function (result) {
                                            if (result.value) {
                                                window.history.back()
                                            }
                                        })
                                    }else{
                                        Swal.fire(
                                            {
                                                icon: "error",
                                                title: 'เกิดข้อผิดพลาด',
                                                text: 'ไม่สามารถดำเนินการได้',
                                                confirmButtonClass: 'btn btn-danger',
                                            }
                                        )
                                    }
                               })
                }
            })
            
        }

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