<?php 
require('../../../../config/config.inc.php');
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

$patient_id = '';
if(isset($_GET['patient_id'])){ 
    $patient_id = mysqli_real_escape_string($conn, $_GET['patient_id']);
}else{
    header('Location: ./app-patient-list-mobile');
}

$menu = 7;

$patient_info = null;
$strSQL = "SELECT * FROM vot2_account a INNER JOIN vot2_userinfo b ON a.username = b.info_username WHERE a.uid = '$patient_id' AND b.info_use = '1'";
$res = $db->fetch($strSQL, false);
if($res){
    $patient_info = $res;
}



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
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/page-user-profile.css">
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
                    <button class="btn pt-0 text-white" onclick="window.history.back()"><i class="bx bx-left-arrow-alt text-white" style="font-size: 2em;"></i></button>
                </div>
                <div class="col-7 th text-white pl-0" style="padding-top: 7px; font-size: 1.2em;">
                จัดการข้อมูลผู้ป่วย
                </div>
                <div class="col-3 th text-white text-right pr-3" >
                <button class="btn btn-icon round pt-0 text-white" style="margin-right: -20px; background: #06c;"  onclick="window.location = 'app-patient-add-mobile'"><i class="bx bx-camera text-white" style="font-size: 1.4em; padding: 6px 0px;"></i></button>
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
            <div class="content-body" style="padding-top: 20px;"> 

            <section class="page-user-profile">
                    <div class="row">
                        <div class="col-12">
                            <!-- user profile heading section start -->
                            <div class="card">
                                <div class="user-profile-images">
                                    <!-- user timeline image -->
                                    <img src="<?php echo $patient_info['profile_img']; ?>" class="img-fluid rounded-top user-timeline-image" alt="user timeline image">
                                    <!-- user profile image -->
                                    <!-- <img src="../../../app-assets/images/portrait/small/avatar-s-16.jpg" class="user-profile-image rounded" alt="user profile image" height="140" width="140"> -->
                                </div>
                                <div class="text-center pt-3">
                                    <h4 class="mb-0 text-bold-500 profile-text-color"><?php echo $patient_info['fname']." ".$patient_info['lname']; ?></h4>
                                    <small><?php echo $patient_info['username']; ?></small>
                                </div>
                                <!-- user profile nav tabs start -->
                                <div class="card-body">
                                    <ul class="nav user-profile-nav justify-content-center justify-content-md-start nav-pills border-bottom-0 mb-0" role="tablist" style="padding-top: 0px !important;">
                                        <li class="nav-item mb-0">
                                            <a class=" nav-link d-flex px-1 active" id="feed-tab" data-toggle="tab" href="#feed" aria-controls="feed" role="tab" aria-selected="true"><i class="bx bx-user"></i><span class="d-none d-md-block">Feed</span></a>
                                        </li>
                                        <li class="nav-item mb-0">
                                            <a class="nav-link d-flex px-1" id="activity-tab" data-toggle="tab" href="#activity" aria-controls="activity" role="tab" aria-selected="false"><i class="bx bx-capsule"></i><span class="d-none d-md-block">Activity</span></a>
                                        </li>
                                        <li class="nav-item mb-0">
                                            <a class="nav-link d-flex px-1" id="friends-tab" data-toggle="tab" href="#friends" aria-controls="friends" role="tab" aria-selected="false"><i class="bx bx-calendar"></i><span class="d-none d-md-block">Friends</span></a>
                                        </li>
                                        <li class="nav-item mb-0 mr-0">
                                            <a class="nav-link d-flex px-1" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" role="tab" aria-selected="false"><i class="bx bx-key"></i><span class="d-none d-md-block">Profile</span></a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- user profile nav tabs ends -->
                            </div>
                            <!-- user profile heading section ends -->

                            <!-- user profile content section start -->
                            <div class="row">
                                <!-- user profile nav tabs content start -->
                                <div class="col-lg-9">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="feed" aria-labelledby="feed-tab" role="tabpanel">
                                            <!-- user profile nav tabs feed start -->
                                            <div class="row">
                                                <!-- user profile nav tabs feed left section start -->
                                                <div class="col-lg-4">
                                                    <!-- user profile nav tabs feed left section info card start -->
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-1">ข้อมูลส่วนตัว
                                                                <i class="cursor-pointer bx bx-dots-vertical-rounded float-right"></i>
                                                            </h5>

                                                            <div class="form-group">
                                                                <label for="">ชื่อ : <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="txtFname" value="<?php echo $patient_info['fname'];?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">นามสกุล : <span class="text-danger">*</span> </label>
                                                                <input type="text" class="form-control" id="txtFname" value="<?php echo $patient_info['lname'];?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">หมายเลขโทรศัพท์ : <span class="text-danger">*</span> </label>
                                                                <input type="text" class="form-control" id="txtPhone" value="<?php echo $patient_info['phone'];?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">หมายเลขโทรศัพท์ญาติ : </label>
                                                                <input type="text" class="form-control" id="xtRelativePhone" value="<?php echo $patient_info['relative_phone'];?>">
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-1">สถานบริการและพี่เลี้ยง
                                                                <i class="cursor-pointer bx bx-dots-vertical-rounded float-right"></i>
                                                            </h5>

                                                            <div class="form-group">
                                                                <label for="">หน่วย/สถานบริการที่ขึ้นทะเบียนผู้ป่วย : <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="txtFname" value="<?php echo $patient_info['fname'];?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">หน่วย/สถานบริการสุขภาพที่ตรวจติดตาม : <span class="text-danger">*</span> </label>
                                                                <input type="text" class="form-control" id="txtFname" value="<?php echo $patient_info['lname'];?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">หน่วย/สถานบริการสุขภาพของพี่เลี้ยง : <span class="text-danger">*</span> </label>
                                                                <input type="text" class="form-control" id="txtPhone" value="<?php echo $patient_info['phone'];?>">
                                                            </div>

                                                            <?php 
                                                            if($_SESSION['thvot_role'] == 'manager'){
                                                                ?>
                                                                <div class="form-group">
                                                                    <label for="">พี่เลี้ยง : <span class="text-danger">*</span> </label>
                                                                    <select name="txtStaff" id="txtStaff" class="form-control">
                                                                        <option value="">-- เลือกพี่เลี้ยง --</option>
                                                                    </select>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>

                                                            <div class="form-group">
                                                                <label for="">หมายเลขโทรศัพท์ญาติ : </label>
                                                                <input type="text" class="form-control" id="xtRelativePhone" value="<?php echo $patient_info['relative_phone'];?>">
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-1">ที่อยู่</h5>

                                                            <div class="form-group">
                                                                <label for="">จังหวัด : <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="txtFname" value="<?php echo $patient_info['fname'];?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">อำเภอ : <span class="text-danger">*</span> </label>
                                                                <input type="text" class="form-control" id="txtFname" value="<?php echo $patient_info['lname'];?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="">ตำบล : <span class="text-danger">*</span> </label>
                                                                <input type="text" class="form-control" id="txtPhone" value="<?php echo $patient_info['phone'];?>">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    
                                                    <!-- user profile nav tabs feed left section like page card ends -->
                                                    <!-- user profile nav tabs feed left section today's events card start -->
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-1">Today's Events<i class="cursor-pointer bx bx-dots-vertical-rounded float-right"></i>
                                                            </h5>
                                                            <div class="user-profile-event">
                                                                <div class="pb-1 d-flex align-items-center">
                                                                    <i class="cursor-pointer bx bx-radio-circle-marked text-primary mr-25"></i>
                                                                    <small>10:00am</small>
                                                                </div>
                                                                <h6 class="text-bold-500 font-small-3">Breakfast at the agency</h6>
                                                                <p class="text-muted font-small-2">Multi language support enable you to create your
                                                                    personalized apps in your language.</p>
                                                                <i class="cursor-pointer bx bx-map text-muted align-middle"></i>
                                                                <span class="text-muted"><small>Monkdev Agency</small></span>
                                                                <!-- user profile likes avatar start -->
                                                                <ul class="list-unstyled users-list d-flex align-items-center mt-1">
                                                                    <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" title="Lilian Nenez" class="avatar pull-up">
                                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-21.jpg" alt="Avatar" height="30" width="30">
                                                                    </li>
                                                                    <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" title="Alberto Glotzbach" class="avatar pull-up">
                                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-22.jpg" alt="Avatar" height="30" width="30">
                                                                    </li>
                                                                    <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" title="Alberto Glotzbach" class="avatar pull-up">
                                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-23.jpg" alt="Avatar" height="30" width="30">
                                                                    </li>
                                                                    <li class="pl-50 text-muted font-small-3">
                                                                        +10 more
                                                                    </li>
                                                                </ul>
                                                                <!-- user profile likes avatar ends -->
                                                            </div>
                                                            <hr>
                                                            <div class="user-profile-event">
                                                                <div class="pb-1 d-flex align-items-center">
                                                                    <i class="cursor-pointer bx bx-radio-circle-marked text-primary mr-25"></i>
                                                                    <small>10:00pm</small>
                                                                </div>
                                                                <h6 class="text-bold-500 font-small-3">Work eith persistance and you can achive it.</h6>
                                                            </div>
                                                            <hr>
                                                            <div class="user-profile-event">
                                                                <div class="pb-1 d-flex align-items-center">
                                                                    <i class="cursor-pointer bx bx-radio-circle-marked text-primary mr-25"></i>
                                                                    <small>6:00am</small>
                                                                </div>
                                                                <div class="pb-1">
                                                                    <h6 class="text-bold-500 font-small-3">Take that granted hotdog</h6>
                                                                    <i class="cursor-pointer bx bx-map text-muted align-middle"></i>
                                                                    <span class="text-muted"><small>Monkdev Agency</small></span>
                                                                </div>
                                                            </div>
                                                            <button class="btn btn-block btn-secondary">Check all your Events</button>
                                                        </div>
                                                    </div>
                                                    <!-- user profile nav tabs feed left section today's events card ends -->
                                                </div>
                                                <!-- user profile nav tabs feed left section ends -->
                                                <!-- user profile nav tabs feed middle section start -->
                                                <div class="col-lg-8">
                                                    <!-- user profile nav tabs feed middle section post card start -->
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <!-- user profile middle section blogpost nav tabs card start -->
                                                            <ul class="nav nav-pills justify-content-center justify-content-sm-start border-bottom-0" role="tablist">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active d-flex" id="user-status-tab" data-toggle="tab" href="#user-status" aria-controls="user-status" role="tab" aria-selected="true"><i class="bx bx-detail align-text-top"></i>
                                                                        <span class="d-none d-md-block">Status</span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link d-flex" id="multimedia-tab" data-toggle="tab" href="#user-multimedia" aria-controls="user-multimedia" role="tab" aria-selected="false"><i class="bx bx-movie align-text-top"></i>
                                                                        <span class="d-none d-md-block">Multimedia</span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item mr-0">
                                                                    <a class="nav-link d-flex" id="blog-tab" data-toggle="tab" href="#user-blog" aria-controls="user-blog" role="tab" aria-selected="false"><i class="bx bx-chat align-text-top"></i>
                                                                        <span class="d-none d-md-block">Blog Post</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content pl-0">
                                                                <div class="tab-pane active" id="user-status" aria-labelledby="user-status-tab" role="tabpanel">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group row">
                                                                                <div class="col-sm-1 col-2">
                                                                                    <div class="avatar">
                                                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-2.jpg" alt="user image" width="32" height="32">
                                                                                        <span class="avatar-status-online"></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-11 col-10">
                                                                                    <textarea class="form-control border-0 shadow-none" id="user-post-textarea" rows="3" placeholder="Share what you are thinking here..."></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="card-footer p-0">
                                                                                <i class="cursor-pointer bx bx-camera font-medium-5 text-muted mr-1 pt-50" data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" title="Upload a picture"></i>
                                                                                <i class="cursor-pointer bx bx-face font-medium-5 text-muted mr-1 pt-50" data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" title="Tag your friend"></i>
                                                                                <i class="cursor-pointer bx bx-map font-medium-5 text-muted pt-50" data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" title="Share your location"></i>
                                                                                <span class=" float-sm-right d-flex flex-sm-row flex-column justify-content-end">
                                                                                    <button class="btn btn-light-primary mr-0 my-1 my-sm-0 mr-sm-1">Preview</button>
                                                                                    <button class="btn btn-primary">Post Status</button>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane" id="user-multimedia" aria-labelledby="multimedia-tab" role="tabpanel">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group row">
                                                                                <div class="col-sm-1 col-2">
                                                                                    <div class="avatar">
                                                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-2.jpg" alt="user image" width="32" height="32">
                                                                                        <span class="avatar-status-online"></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-11 col-10">
                                                                                    <textarea class="form-control border-0 shadow-none" id="user-postmulti-textarea" rows="3" placeholder="Share what you are thinking here..."></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="card-footer p-0">
                                                                                <i class="cursor-pointer bx bx-camera font-medium-5 text-muted mr-1 pt-50" data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" title="Upload a picture"></i>
                                                                                <i class="cursor-pointer bx bx-face font-medium-5 text-muted mr-1 pt-50" data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" title="Tag your friend"></i>
                                                                                <i class="cursor-pointer bx bx-map font-medium-5 text-muted pt-50" data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" title="Share your location"></i>
                                                                                <span class=" float-sm-right d-flex flex-sm-row flex-column justify-content-end">
                                                                                    <button class="btn btn-light-primary mr-0 my-1 my-sm-0 mr-sm-1">Preview</button>
                                                                                    <button class="btn btn-primary">Post Status</button>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane" id="user-blog" aria-labelledby="blog-tab" role="tabpanel">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group row">
                                                                                <div class="col-sm-1 col-2">
                                                                                    <div class="avatar">
                                                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-2.jpg" alt="user image" width="32" height="32">
                                                                                        <span class="avatar-status-online"></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-11 col-10">
                                                                                    <textarea class="form-control border-0 shadow-none" id="user-postblog-textarea" rows="3" placeholder="Share what you are thinking here..."></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="card-footer p-0">
                                                                                <i class="cursor-pointer bx bx-camera font-medium-5 text-muted mr-1 pt-50" data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" title="Upload a picture"></i>
                                                                                <i class="cursor-pointer bx bx-face font-medium-5 text-muted mr-1 pt-50" data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" title="Tag your friend"></i>
                                                                                <i class="cursor-pointer bx bx-map font-medium-5 text-muted pt-50" data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" title="Share your location"></i>
                                                                                <span class=" float-sm-right d-flex flex-sm-row flex-column justify-content-end">
                                                                                    <button class="btn btn-light-primary mr-0 my-1 my-sm-0 mr-sm-1">Preview</button>
                                                                                    <button class="btn btn-primary">Post Status</button>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- user profile middle section blogpost nav tabs card ends -->
                                                        </div>
                                                    </div>
                                                    <!-- user profile nav tabs feed middle section post card ends -->
                                                    <!-- user profile nav tabs feed middle section user-1 card starts -->
                                                    <div class="card">
                                                        <div class="card-header user-profile-header">
                                                            <div class="avatar mr-50 align-top">
                                                                <img src="../../../app-assets/images/portrait/small/avatar-s-10.jpg" alt="user avatar" width="32" height="32">
                                                                <span class="avatar-status-online"></span>
                                                            </div>
                                                            <div class="d-inline-block mt-25">
                                                                <h6 class="mb-0 text-bold-500">Martina Ash <span class="text-bold-400">shared a
                                                                    </span><a href="JavaScript:void(0);">link</a></h6>
                                                                <p class="text-muted"><small>7 hours ago</small></p>
                                                            </div>
                                                            <i class='cursor-pointer bx bx-dots-vertical-rounded float-right'></i>
                                                        </div>
                                                        <div class="card-body py-0">
                                                            <p>Unlimited color options allows you to set your application color as per your branding 🤩.</p>
                                                            <div class="d-flex border rounded">
                                                                <div class="user-profile-images"><img src="../../../app-assets/images/banner/banner-29.jpg" alt="post" class="img-fluid user-profile-card-image">
                                                                </div>
                                                                <div class="p-1">
                                                                    <h5>Algolia Integration 😎</h5>
                                                                    <p class="user-profile-ellipsis">Algolia helps businesses across industries quickly create
                                                                        relevant, scalable, and lightning fast search and discovery experiences.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer d-flex justify-content-between pt-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="cursor-pointer bx bx-heart user-profile-like font-medium-4"></i>
                                                                <p class="mb-0 ml-25">18</p>
                                                                <!-- user profile likes avatar start -->
                                                                <div class="d-none d-sm-block">
                                                                    <ul class="list-unstyled users-list m-0 d-flex align-items-center ml-1">
                                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" title="Lilian Nenez" class="avatar pull-up">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-21.jpg" alt="Avatar" height="30" width="30">
                                                                        </li>
                                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" title="Alberto Glotzbach" class="avatar pull-up">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-22.jpg" alt="Avatar" height="30" width="30">
                                                                        </li>
                                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" title="Alberto Glotzbach" class="avatar pull-up">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-23.jpg" alt="Avatar" height="30" width="30">
                                                                        </li>
                                                                        <li class="d-inline-block pl-50">
                                                                            <p class="text-muted mb-0 font-small-3">+10 more</p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- user profile likes avatar ends -->
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <i class="cursor-pointer bx bx-comment-dots font-medium-4"></i>
                                                                <span class="ml-25">52</span>
                                                                <i class="cursor-pointer bx bx-share-alt font-medium-4 ml-1"></i>
                                                                <span class="ml-25">22</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- user profile nav tabs feed middle section user-1 card ends -->
                                                    <!-- user profile nav tabs feed middle section story swiper start -->
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-0">Stories</h5>
                                                            <div class="user-profile-stories swiper-container pt-1">
                                                                <div class="swiper-wrapper user-profile-images">
                                                                    <div class="swiper-slide">
                                                                        <img src="../../../app-assets/images/profile/portraits/avatar-portrait-1.jpg" class="rounded user-profile-stories-image" alt="story image">
                                                                        <div class="card-img-overlay bg-overlay">
                                                                            <div class="user-swiper-text">ureka_23</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="swiper-slide">
                                                                        <img src="../../../app-assets/images/profile/portraits/avatar-portrait-2.jpg" class="rounded user-profile-stories-image" alt="story image">
                                                                        <div class="card-img-overlay bg-overlay">
                                                                            <div class="user-swiper-text">devine_lena</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="swiper-slide">
                                                                        <img src="../../../app-assets/images/profile/portraits/avatar-portrait-3.jpg" class="rounded user-profile-stories-image" alt="story image">
                                                                        <div class="card-img-overlay bg-overlay">
                                                                            <div class="user-swiper-text">venice_like852</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="swiper-slide">
                                                                        <img src="../../../app-assets/images/profile/portraits/avatar-portrait-4.jpg" class="rounded user-profile-stories-image" alt="story image">
                                                                        <div class="card-img-overlay bg-overlay">
                                                                            <div class="user-swiper-text">june5211</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="swiper-slide">
                                                                        <img src="../../../app-assets/images/profile/portraits/avatar-portrait-5.jpg" class="rounded user-profile-stories-image" alt="story image">
                                                                        <div class="card-img-overlay bg-overlay">
                                                                            <div class="user-swiper-text">defloya_456</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- user profile nav tabs feed middle section story swiper ends -->
                                                    <!-- user profile nav tabs feed middle section user-2 card starts -->
                                                    <div class="card">
                                                        <div class="card-header user-profile-header">
                                                            <div class="avatar mr-50 align-top">
                                                                <img src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="avtar image" width="32" height="32">
                                                                <span class="avatar-status-offline"></span>
                                                            </div>
                                                            <div class="d-inline-block mt-25">
                                                                <h6 class="mb-0 text-bold-500">Jonny Richie</h6>
                                                                <p class="text-muted"><small>2 hours ago</small></p>
                                                            </div>
                                                            <i class="cursor-pointer bx bx-dots-vertical-rounded float-right"></i>
                                                        </div>
                                                        <div class="card-body py-0">
                                                            <p>Beautifully crafted, clean & modern designed admin✨ theme with 3 different demos & light -
                                                                dark versions. Lifetime updates with new demos and features is guaranteed</p>
                                                        </div>
                                                        <div class="card-footer d-flex justify-content-between pb-0">
                                                            <div class="d-flex align-items-center">
                                                                <i class="cursor-pointer bx bx-heart user-profile-like font-medium-4"></i>
                                                                <p class="mb-0 ml-25">49</p>
                                                                <!-- user profile likes avatar start -->
                                                                <div class="d-none d-sm-block">
                                                                    <ul class="list-unstyled users-list m-0 d-flex align-items-center ml-1">
                                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" title="Lilian Nenez" class="avatar pull-up">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-24.jpg" alt="Avatar" height="30" width="30">
                                                                        </li>
                                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" title="Alberto Glotzbach" class="avatar pull-up">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-25.jpg" alt="Avatar" height="30" width="30">
                                                                        </li>
                                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" title="Alberto Glotzbach" class="avatar pull-up">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-26.jpg" alt="Avatar" height="30" width="30">
                                                                        </li>
                                                                        <li class="d-inline-block pl-50">
                                                                            <p class="text-muted mb-0 font-small-3">+10 more</p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- user profile likes avatar ends -->
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <i class="cursor-pointer bx bx-comment-dots font-medium-4"></i>
                                                                <span class="ml-25">45</span>
                                                                <i class="cursor-pointer bx bx-share-alt font-medium-4 ml-1"></i>
                                                                <span class="ml-25">1</span>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <!-- user profile comments start -->
                                                        <div class="card-header user-profile-header pt-0">
                                                            <div class="avatar mr-50 align-top">
                                                                <img src="../../../app-assets/images/portrait/small/avatar-s-12.jpg" alt="avtar image" width="32" height="32">
                                                                <span class="avatar-status-away"></span>
                                                            </div>
                                                            <div class="d-inline-block mt-25">
                                                                <h6 class="mb-0 text-bold-500 font-small-3">Ananbella Queen</h6>
                                                                <p class="text-muted"><small>24 mins ago</small></p>
                                                            </div>
                                                            <i class='cursor-pointer bx bx-dots-vertical-rounded float-right'></i>
                                                        </div>
                                                        <div class="card-body py-0">
                                                            <p>Easy & smart fuzzy search🕵🏻 functionality which enables users to search quickly.</p>
                                                        </div>
                                                        <div class="card-footer user-comment-footer pb-0">
                                                            <i class="cursor-pointer bx bx-heart user-profile-like font-medium-4 align-middle"></i>
                                                            <span class="ml-25">30</span>
                                                            <span class="ml-1">reply</span>
                                                        </div>
                                                        <hr>
                                                        <div class="card-header user-profile-header pt-0">
                                                            <div class="avatar mr-50 align-top">
                                                                <img src="../../../app-assets/images/portrait/small/avatar-s-13.jpg" alt="avtar images" width="32" height="32">
                                                                <span class="avatar-status-busy"></span>
                                                            </div>
                                                            <div class="d-inline-block mt-25">
                                                                <h6 class="mb-0 text-bold-500 font-small-3">Jackey Potter</h6>
                                                                <p class="text-muted"><small>1 hours ago</small></p>
                                                            </div>
                                                            <i class='cursor-pointer bx bx-dots-vertical-rounded float-right'></i>
                                                        </div>
                                                        <div class="card-body py-0">
                                                            <p>Unlimited color🖌 options allows you to set your application color as per your branding 🤪.</p>
                                                        </div>
                                                        <div class="card-footer user-comment-footer pb-0">
                                                            <i class="cursor-pointer bx bx-heart user-profile-like font-medium-4 align-middle"></i>
                                                            <span class="ml-25">80</span>
                                                            <span class="ml-1">reply</span>
                                                        </div>
                                                        <hr>
                                                        <div class="form-group row align-items-center px-1">
                                                            <div class="col-2 col-sm-1">
                                                                <div class="avatar">
                                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-2.jpg" alt="avtar images" width="32" height="32">
                                                                    <span class="avatar-status-online"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-11 col-10">
                                                                <textarea class="form-control" id="user-comment-textarea" rows="1" placeholder="comment.."></textarea>
                                                            </div>
                                                        </div>
                                                        <!-- user profile comments ends -->
                                                    </div>
                                                    <!-- user profile nav tabs feed middle section user-2 card ends -->
                                                    <!-- user profile nav tabs feed middle section user-3 card starts -->
                                                    <div class="card">
                                                        <div class="card-header user-profile-header">
                                                            <div class="avatar mr-50 align-top">
                                                                <img src="../../../app-assets/images/portrait/small/avatar-s-14.jpg" alt="avtar images" width="32" height="32">
                                                                <span class="avatar-status-online"></span>
                                                            </div>
                                                            <div class="d-inline-block mt-25">
                                                                <h6 class="mb-0 text-bold-500">Anna Mull</h6>
                                                                <p class="text-muted"><small>7 hours ago</small></p>
                                                            </div>
                                                            <i class='cursor-pointer bx bx-dots-vertical-rounded float-right'></i>
                                                        </div>
                                                        <div class="card-body py-0">
                                                            <p>To avoid winding up with a large bundle, it’s good to get ahead of the problem and use "Code
                                                                Splitting 🕹".</p>
                                                            <img src="../../../app-assets/images/profile/post-media/2.jpg" alt="user image" class="img-fluid">
                                                        </div>
                                                        <div class="card-footer d-flex justify-content-between pt-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="cursor-pointer bx bx-heart user-profile-like font-medium-4"></i>
                                                                <p class="mb-0 ml-25">77</p>
                                                                <!-- user profile likes avatar start -->
                                                                <div class="d-none d-sm-block">
                                                                    <ul class="list-unstyled users-list m-0 d-flex align-items-center ml-1">
                                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" title="Lilian Nenez" class="avatar pull-up">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="Avatar" height="30" width="30">
                                                                        </li>
                                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" title="Alberto Glotzbach" class="avatar pull-up">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-12.jpg" alt="Avatar" height="30" width="30">
                                                                        </li>
                                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" title="Alberto Glotzbach" class="avatar pull-up">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-13.jpg" alt="Avatar" height="30" width="30">
                                                                        </li>
                                                                        <li class="d-inline-block pl-50">
                                                                            <p class="text-muted mb-0 font-small-3">+10 more</p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- user profile likes avatar ends -->
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <i class="cursor-pointer bx bx-comment-dots font-medium-4"></i>
                                                                <span class="ml-25">12</span>
                                                                <i class="cursor-pointer bx bx-share-alt font-medium-4 ml-1"></i>
                                                                <span class="ml-25">12</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- user profile nav tabs feed middle section user-3 card ends -->
                                                    <!-- user profile nav tabs feed middle section user-4 card starts -->
                                                    <div class="card">
                                                        <div class="card-header user-profile-header">
                                                            <div class="avatar mr-50 align-top">
                                                                <img src="../../../app-assets/images/portrait/small/avatar-s-18.jpg" alt="avtar images" width="32" height="32">
                                                                <span class="avatar-status-online"></span>
                                                            </div>
                                                            <div class="d-inline-block mt-25">
                                                                <h6 class="mb-0 text-bold-500">Petey Cruiser</h6>
                                                                <p class="text-muted"><small>21 hours ago</small></p>
                                                            </div>
                                                            <i class='cursor-pointer bx bx-dots-vertical-rounded float-right'></i>
                                                        </div>
                                                        <div class="card-body py-0">
                                                            <p>It's more efficient 🙌 to split each route's components into a separate chunk, and only load
                                                                them when the route is visited. Frest comes with built-in light and dark layouts, select as
                                                                per your preference.</p>
                                                        </div>
                                                        <div class="card-footer d-flex justify-content-between pt-1">
                                                            <div class="d-flex align-items-center">
                                                                <i class="cursor-pointer bx bx-heart user-profile-like font-medium-4"></i>
                                                                <p class="mb-0 ml-25">0</p>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <i class="cursor-pointer bx bx-comment-dots font-medium-4"></i>
                                                                <span class="ml-25">0</span>
                                                                <i class="cursor-pointer bx bx-share-alt font-medium-4 ml-1"></i>
                                                                <span class="ml-25">2</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- user profile nav tabs feed middle section user-4 card ends -->
                                                </div>
                                                <!-- user profile nav tabs feed middle section ends -->
                                            </div>
                                            <!-- user profile nav tabs feed ends -->
                                        </div>
                                        <div class="tab-pane " id="activity" aria-labelledby="activity-tab" role="tabpanel">
                                            <!-- user profile nav tabs activity start -->
                                            <div class="card">
                                                <div class="card-body">
                                                    <!-- timeline start -->
                                                    <ul class="timeline">
                                                        <li class="timeline-item timeline-icon-success active">
                                                            <div class="timeline-time">Tue 8:17pm</div>
                                                            <h6 class="timeline-title">Martina Ash</h6>
                                                            <p class="timeline-text">on <a href="JavaScript:void(0);">Received Gift</a></p>
                                                            <div class="timeline-content">
                                                                Welcome to video game and lame is very creative
                                                            </div>
                                                        </li>
                                                        <li class="timeline-item timeline-icon-primary active">
                                                            <div class="timeline-time">5 days ago</div>
                                                            <h6 class="timeline-title">Jonny Richie attached file</h6>
                                                            <p class="timeline-text">on <a href="JavaScript:void(0);">Project name</a></p>
                                                            <div class="timeline-content">
                                                                <img src="../../../app-assets/images/icon/sketch.png" alt="document" height="36" width="27" class="mr-50">Data Folder
                                                            </div>
                                                        </li>
                                                        <li class="timeline-item timeline-icon-danger active">
                                                            <div class="timeline-time">7 hours ago</div>
                                                            <h6 class="timeline-title">Mathew Slick docs</h6>
                                                            <p class="timeline-text">on <a href="JavaScript:void(0);">Project name</a></p>
                                                            <div class="timeline-content">
                                                                <img src="../../../app-assets/images/icon/pdf.png" alt="document" height="36" width="27" class="mr-50">Received Pdf
                                                            </div>
                                                        </li>
                                                        <li class="timeline-item timeline-icon-info active">
                                                            <div class="timeline-time">5 hour ago</div>
                                                            <h6 class="timeline-title">Petey Cruiser send you a message</h6>
                                                            <p class="timeline-text">on <a href="JavaScript:void(0);">Redited message</a></p>
                                                            <div class="timeline-content">
                                                                Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it
                                                                is
                                                                pain, but because occasionally circumstances
                                                            </div>
                                                        </li>
                                                        <li class="timeline-item timeline-icon-warning">
                                                            <div class="timeline-time">2 min ago</div>
                                                            <h6 class="timeline-title">Anna mull liked </h6>
                                                            <p class="timeline-text">on <a href="JavaScript:void(0);">Liked</a></p>
                                                            <div class="timeline-content">
                                                                The Amairates
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <!-- timeline ends -->
                                                    <div class="text-center">
                                                        <button class="btn btn-primary">View All Activity</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- user profile nav tabs activity start -->
                                        </div>
                                        <div class="tab-pane" id="friends" aria-labelledby="friends-tab" role="tabpanel">
                                            <!-- user profile nav tabs friends start -->
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5>Friends</h5>
                                                    <div class="row">
                                                        <div class="col-sm-6 col-12">
                                                            <ul class="list-unstyled mb-0">
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-2.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-online"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">Petey Cruiser</a></h6>
                                                                        <small class="text-muted">Flask</small>
                                                                    </div>
                                                                </li>
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-3.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-offline"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">Anna Sthesia</a></h6>
                                                                        <small class="text-muted">Devloper</small>
                                                                    </div>
                                                                </li>
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-4.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-busy"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">Paul Molive</a></h6>
                                                                        <small class="text-muted">Designer</small>
                                                                    </div>
                                                                </li>
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-5.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-busy"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">Anna Mull</a></h6>
                                                                        <small class="text-muted">Worker</small>
                                                                    </div>
                                                                </li>
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-5.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-away"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">Gail Forcewind</a></h6>
                                                                        <small class="text-muted">Lawyer</small>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-sm-6 col-12">
                                                            <ul class="list-unstyled mb-0">
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-16.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-offline"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">Paige Turner</a></h6>
                                                                        <small class="text-muted">Student</small>
                                                                    </div>
                                                                </li>
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-7.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-busy"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">Bob Frapples</a></h6>
                                                                        <small class="text-muted">Professor</small>
                                                                    </div>
                                                                </li>
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-8.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-online"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">Mario super</a></h6>
                                                                        <small class="text-muted">Scientist</small>
                                                                    </div>
                                                                </li>
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-2.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-online"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">Petey Cruiser</a></h6>
                                                                        <small class="text-muted">Flask</small>
                                                                    </div>
                                                                </li>
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-3.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-offline"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">Anna Sthesia</a></h6>
                                                                        <small class="text-muted">Devloper</small>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <h5 class="mt-2">Mutual Friends</h5>
                                                    <div class="row">
                                                        <div class="col-sm-6 col-12">
                                                            <ul class="list-unstyled mb-0">
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-26.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-online"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">jackeu decoy</a></h6>
                                                                        <small class="text-muted">Network</small>
                                                                    </div>
                                                                </li>
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-25.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-offline"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">Sthesia Anna</a></h6>
                                                                        <small class="text-muted">Devloper</small>
                                                                    </div>
                                                                </li>
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-24.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-busy"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">Molive Paul</a></h6>
                                                                        <small class="text-muted">Designer</small>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-sm-6 col-12">
                                                            <ul class="list-unstyled mb-0">
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-23.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-busy"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">Mull Anna</a></h6>
                                                                        <small class="text-muted">Worker</small>
                                                                    </div>
                                                                </li>
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-22.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-away"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">Forcewind Gail</a></h6>
                                                                        <small class="text-muted">Lawyer</small>
                                                                    </div>
                                                                </li>
                                                                <li class="media my-50">
                                                                    <a href="JavaScript:void(0);">
                                                                        <div class="avatar mr-1">
                                                                            <img src="../../../app-assets/images/portrait/small/avatar-s-21.jpg" alt="avtar images" width="32" height="32">
                                                                            <span class="avatar-status-offline"></span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <h6 class="media-heading mb-0"><a href="javaScript:void(0);">Paige Turner</a></h6>
                                                                        <small class="text-muted">Student</small>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- user profile nav tabs friends ends -->
                                        </div>
                                        <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
                                            <!-- user profile nav tabs profile start -->
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-12 col-sm-3 text-center mb-1 mb-sm-0">
                                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-16.jpg" class="rounded" alt="group image" height="120" width="120" />
                                                                </div>
                                                                <div class="col-12 col-sm-9">
                                                                    <div class="row">
                                                                        <div class="col-12 text-center text-sm-left">
                                                                            <h6 class="media-heading mb-0">valintini_007<i class="cursor-pointer bx bxs-star text-warning ml-50 align-middle"></i></h6>
                                                                            <small class="text-muted align-top">Martina Ash</small>
                                                                        </div>
                                                                        <div class="col-12 text-center text-sm-left">
                                                                            <div class="mb-1">
                                                                                <span class="mr-1">122 <small>Posts</small></span>
                                                                                <span class="mr-1">4.7k <small>Followers</small></span>
                                                                                <span class="mr-1">652 <small>Following</small></span>
                                                                            </div>
                                                                            <p>Algolia helps businesses across industries quickly create relevant😎, scalable😀, and
                                                                                lightning😍
                                                                                fast search and discovery experiences.</p>
                                                                            <div>
                                                                                <div class="badge badge-light-primary badge-round mr-1 mb-1" data-toggle="tooltip" data-placement="bottom" title="with 7% growth @valintini_007 is on top 5k"><i class="cursor-pointer bx bx-check-shield"></i>
                                                                                </div>
                                                                                <div class="badge badge-light-warning badge-round mr-1 mb-1" data-toggle="tooltip" data-placement="bottom" title="last 55% growth @valintini_007 is on weedday"><i class="cursor-pointer bx bx-badge-check"></i>
                                                                                </div>
                                                                                <div class="badge badge-light-success badge-round mb-1" data-toggle="tooltip" data-placement="bottom" title="got premium profile here"><i class="cursor-pointer bx bx-award"></i>
                                                                                </div>
                                                                            </div>
                                                                            <button class="btn btn-sm d-none d-sm-block float-right btn-light-primary">
                                                                                <i class="cursor-pointer bx bx-edit font-small-3 mr-50"></i><span>Edit</span>
                                                                            </button>
                                                                            <button class="btn btn-sm d-block d-sm-none btn-block text-center btn-light-primary">
                                                                                <i class="cursor-pointer bx bx-edit font-small-3 mr-25"></i><span>Edit</span></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Basic details</h5>
                                                    <ul class="list-unstyled">
                                                        <li><i class="cursor-pointer bx bx-map mb-1 mr-50"></i>California</li>
                                                        <li><i class="cursor-pointer bx bx-phone-call mb-1 mr-50"></i>(+56) 454 45654 </li>
                                                        <li><i class="cursor-pointer bx bx-time mb-1 mr-50"></i>July 10</li>
                                                        <li><i class="cursor-pointer bx bx-envelope mb-1 mr-50"></i>Jonnybravo@gmail.com</li>
                                                    </ul>
                                                    <div class="row">
                                                        <div class="col-sm-6 col-12">
                                                            <h6><small class="text-muted">Cell Phone</small></h6>
                                                            <p>(+46) 456 54432</p>
                                                        </div>
                                                        <div class="col-sm-6 col-12">
                                                            <h6><small class="text-muted">Family Phone</small></h6>
                                                            <p>(+46) 454 22432</p>
                                                        </div>
                                                        <div class="col-sm-6 col-12">
                                                            <h6><small class="text-muted">Reporter</small></h6>
                                                            <p>John Doe</p>
                                                        </div>
                                                        <div class="col-sm-6 col-12">
                                                            <h6><small class="text-muted">Manager</small></h6>
                                                            <p>Richie Rich</p>
                                                        </div>
                                                        <div class="col-12">
                                                            <h6><small class="text-muted">Bio</small></h6>
                                                            <p>Built-in customizer enables users to change their admin panel look & feel based on their
                                                                preferences Beautifully crafted, clean & modern designed admin theme with 3 different demos &
                                                                light - dark versions.</p>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-sm d-none d-sm-block float-right btn-light-primary mb-2">
                                                        <i class="cursor-pointer bx bx-edit font-small-3 mr-50"></i><span>Edit</span>
                                                    </button>
                                                    <button class="btn btn-sm d-block d-sm-none btn-block text-center btn-light-primary">
                                                        <i class="cursor-pointer bx bx-edit font-small-3 mr-25"></i><span>Edit</span></button>
                                                </div>
                                            </div>
                                            <!-- user profile nav tabs profile ends -->
                                        </div>
                                    </div>
                                </div>
                                <!-- user profile nav tabs content ends -->
                                <!-- user profile right side content start -->
                                <div class="col-lg-3">
                                    <!-- user profile right side content birthday card start -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-inline-flex">
                                                <div class="avatar mr-50">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-20.jpg" alt="avtar images" height="32" width="32">
                                                </div>
                                                <h6 class="mb-0 d-flex align-items-center"> Nile's Birthday!</h6>
                                            </div>
                                            <i class="cursor-pointer bx bx-dots-vertical-rounded float-right"></i>
                                            <div class="user-profile-birthday-image text-center p-2">
                                                <img class="img-fluid" src="../../../app-assets/images/profile/pages/birthday.png" alt="image">
                                            </div>
                                            <div class="user-profile-birthday-footer text-center text-lg-left">
                                                <p class="mb-0"><small>Leave her a message with your best wishes on her profile page!</small></p>
                                                <a class="btn btn-sm btn-light-primary mt-50" href="JavaScript:void(0);">Send Wish</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- user profile right side content birthday card ends -->
                                    <!-- user profile right side content related groups start -->
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-1">Related Groups
                                                <i class="cursor-pointer bx bx-dots-vertical-rounded align-top float-right"></i>
                                            </h5>
                                            <div class="media d-flex align-items-center mb-1">
                                                <a href="JavaScript:void(0);">
                                                    <img src="../../../app-assets/images/banner/banner-30.jpg" class="rounded" alt="group image" height="64" width="64" />
                                                </a>
                                                <div class="media-body ml-1">
                                                    <h6 class="media-heading mb-0"><small>Play Guitar</small></h6><small class="text-muted">2.8k
                                                        members (7 joined)</small>
                                                </div>
                                                <i class="cursor-pointer bx bx-plus-circle text-primary d-flex align-items-center "></i>
                                            </div>
                                            <div class="media d-flex align-items-center mb-1">
                                                <a href="JavaScript:void(0);">
                                                    <img src="../../../app-assets/images/banner/banner-31.jpg" class="rounded" alt="group image" height="64" width="64" />
                                                </a>
                                                <div class="media-body ml-1">
                                                    <h6 class="media-heading mb-0"><small>Generic memes</small></h6><small class="text-muted">9k
                                                        members (7 joined)</small>
                                                </div>
                                                <i class="cursor-pointer bx bx-plus-circle text-primary d-flex align-items-center "></i>
                                            </div>
                                            <div class="media d-flex align-items-center">
                                                <a href="JavaScript:void(0);">
                                                    <img src="../../../app-assets/images/banner/banner-32.jpg" class="rounded" alt="group image" height="64" width="64" />
                                                </a>
                                                <div class="media-body ml-1">
                                                    <h6 class="media-heading mb-0"><small>Cricket fan club</small></h6><small class="text-muted">7.6k
                                                        members</small>
                                                </div>
                                                <i class="cursor-pointer bx bx-lock text-muted d-flex align-items-center"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- user profile right side content related groups ends -->
                                    
                                </div>
                                <!-- user profile right side content ends -->
                            </div>
                            <!-- user profile content section start -->
                        </div>
                    </div>
                </section>
            
                

            </div>
        </div>
    </div>
    <!-- END: Content-->


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
        $recentOrder = '';
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

        function callPhone(s){
            $('#callModal').modal('hide')
            if(s == '1'){
                if($('#txtPhone').val() == ''){
                    alert('ไม่พบหมายเลขโทรศัพท์ผู้ป่วย')
                }else{
                    window.open('tel:' + $('#txtPhone_' + $recentOrder).val());
                }
            }else{
                if($('#txtRelativePhone').val() == ''){
                    alert('ไม่พบหมายเลขโทรศัพท์ญาติผู้ป่วย')
                }else{
                    window.open('tel:' + $('#txtRelativePhone_' + $recentOrder).val());
                }
            }
        }

        function callModal(s){
            $recentOrder = s;
            $('#callModal').modal()
        }
    </script>
</body>
<!-- END: Body-->

</html>