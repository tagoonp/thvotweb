<?php 
require('../../../../../database_config/thvot/config.inc.php');
require('../../../config/configuration.php');
require('../../../config/database.php'); 
require('../../../config/admin.role.php'); 

$db = new Database();
$conn = $db->conn();

$stage = '1';
if((!isset($_GET['stage'])) || (!isset($_GET['uid']))){ 
    $db->close();
    header('Location: ../../../404.php');
    die();
}


if(isset($_GET['stage'])){
    $stage = mysqli_real_escape_string($conn, $_GET['stage']);
}
// require('../../../config/user.inc.php'); 

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
    <title>THVOT Report</title>
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
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-sticky footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">


    <div style="position: fixed; width: 100%; top: 0px; left: 0px; background: #fff; padding: 0px; z-index: 999;">
        <div class="row">
            <div class="col-sm-12">
                <!-- simple sizes -->
                <div class="btn-group btn-group-lg mb-0" role="group" aria-label="Size Large" style="border-radius: 0px; width: 100%;">
                    <button type="button" class="btn <?php if($stage == '1'){ echo "btn-primary"; }else{ echo "btn-outline-primary"; } ?>" <?php if($stage != '1'){ ?> onclick="window.location = 'app-map-mobile.php?stage=1&session_view=1'" <?php } ?> style="border-radius: 0px;">ภาพรวม</button>
                    <button type="button" class="btn <?php if($stage == '2'){ echo "btn-primary"; }else{ echo "btn-outline-primary"; } ?>" <?php if($stage != '2'){ ?> onclick="window.location = 'app-map-mobile.php?stage=2&session_view=1'" <?php } ?>  style="border-radius: 0px;">Map 1</button>
                    <button type="button" class="btn <?php if($stage == '3'){ echo "btn-primary"; }else{ echo "btn-outline-primary"; } ?>" <?php if($stage != '3'){ ?> onclick="window.location = 'app-map-mobile.php?stage=3&session_view=1'" <?php } ?>   style="border-radius: 0px;">Map 2</button>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Content-->
    <div class="app-content content" style="padding: 0px;">
        <div class="content-overlay"></div>
        <div class="content-wrapper" style="padding: 0px;">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <?php 
                if($stage == '1'){
                    ?>
                    <div  style="padding: 20px;">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>อำเภอ</th>
                                            <th>จำนวนผู้ป่วย</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $strSQL = "SELECT * FROM vot2_ampur WHERE Changwat = '90'";
                                        $res = $db->fetch($strSQL, true, false);
                                        if(($res) && ($res['status'])){
                                            foreach ($res['data'] as $row) {
                                                ?>
                                                 <tr>
                                                    <td><?php echo $row['Name'];?></td>
                                                    <td>
                                                        <?php 
                                                        $strSQL = "SELECT COUNT(uid) cn FROM vot2_account WHERE role = 'patient' AND delete_status = '0' AND hcode IN (SELECT hoscode FROM vot2_chospital WHERE provcode = '90' AND distcode = '".$row['Ampur']."')";
                                                        $res2 = $db->fetch($strSQL, false);
                                                        if($res2){
                                                            echo $res2['cn'];
                                                        }else{
                                                            echo "0";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <tr>
                                                <td colspan="2" class="text-center">ไม่พบข้อมูล</td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                }else if($stage == '2'){
                    ?>
                    <iframe src="https://thvot.com/myMap.html" id="mapDiv" height="600" width="100%" title="THVOT facilities map" style="border:none;"></iframe>
                    <?php
                }else if($stage == '3'){
                    ?>
                    <iframe src="https://thvot.com/myMap2.html" id="mapDiv" height="600" width="100%" title="THVOT facilities map" style="border:none;"></iframe>
                    <?php
                }
                ?>
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

</body>
<!-- END: Body-->

</html>