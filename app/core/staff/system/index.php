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
    <title>THVOT : Administator</title>
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
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                    <div class="row">
                        <!-- Greetings Content Starts -->
                        <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="greeting-text">Congratulations John!</h3>
                                    <p class="mb-0">Best seller of the month</p>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="d-flex justify-content-between align-items-end">
                                        <div class="dashboard-content-left">
                                            <h1 class="text-primary font-large-2 text-bold-500">$89k</h1>
                                            <p>You have done 57.6% more sales today.</p>
                                            <button type="button" class="btn btn-primary glow">View Sales</button>
                                        </div>
                                        <div class="dashboard-content-right">
                                            <img src="../../../app-assets/images/icon/cup.png" height="220" width="220" class="img-fluid" alt="Dashboard Ecommerce" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Multi Radial Chart Starts -->
                        <div class="col-xl-4 col-md-6 col-12 dashboard-visit">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">Visits of 2020</h4>
                                    <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                                </div>
                                <div class="card-body">
                                    <div id="multi-radial-chart"></div>
                                    <ul class="list-inline text-center mt-1 mb-0">
                                        <li class="mr-2"><span class="bullet bullet-xs bullet-primary mr-50"></span>Target</li>
                                        <li class="mr-2"><span class="bullet bullet-xs bullet-danger mr-50"></span>Mart</li>
                                        <li><span class="bullet bullet-xs bullet-warning mr-50"></span>Ebay</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-12 dashboard-users">
                            <div class="row  ">
                                <!-- Statistics Cards Starts -->
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-sm-6 col-12 dashboard-users-success">
                                            <div class="card text-center">
                                                <div class="card-body py-1">
                                                    <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                                        <i class="bx bx-briefcase-alt font-medium-5"></i>
                                                    </div>
                                                    <div class="text-muted line-ellipsis">New Products</div>
                                                    <h3 class="mb-0">1.2k</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12 dashboard-users-danger">
                                            <div class="card text-center">
                                                <div class="card-body py-1">
                                                    <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">
                                                        <i class="bx bx-user font-medium-5"></i>
                                                    </div>
                                                    <div class="text-muted line-ellipsis">New Users</div>
                                                    <h3 class="mb-0">45.6k</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-6 col-12 dashboard-revenue-growth">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between align-items-center pb-0">
                                                    <h4 class="card-title">Revenue Growth</h4>
                                                    <div class="d-flex align-items-end justify-content-end">
                                                        <span class="mr-25">$25,980</span>
                                                        <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                                                    </div>
                                                </div>
                                                <div class="card-body pb-0">
                                                    <div id="revenue-growth-chart"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Revenue Growth Chart Starts -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-8 col-12 dashboard-order-summary">
                            <div class="card">
                                <div class="row">
                                    <!-- Order Summary Starts -->
                                    <div class="col-md-8 col-12 order-summary border-right pr-md-0">
                                        <div class="card mb-0">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h4 class="card-title">Order Summary</h4>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-sm btn-light-primary mr-1">Week</button>
                                                    <button type="button" class="btn btn-sm btn-primary glow">Month</button>
                                                </div>
                                            </div>
                                            <div class="card-body p-0">
                                                <div id="order-summary-chart"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Sales History Starts -->
                                    <div class="col-md-4 col-12 pl-md-0">
                                        <div class="card mb-0">
                                            <div class="card-header pb-50">
                                                <h4 class="card-title">Best Sellers</h4>
                                            </div>
                                            <div class="card-body py-1">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div class="sales-item-name">
                                                        <p class="mb-0">iPhone</p>
                                                        <small class="text-muted">Smartphone</small>
                                                    </div>
                                                    <h6 class='mb-0'>794</h6>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div class="sales-item-name">
                                                        <p class="mb-0">Airpods</p>
                                                        <small class="text-muted">Earphone</small>
                                                    </div>
                                                    <h6 class='mb-0'>550</h6>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="sales-item-name">
                                                        <p class="mb-0">MacBook</p>
                                                        <small class="text-muted">Laptop</small>
                                                    </div>
                                                    <h6 class='mb-0'>271</h6>
                                                </div>
                                            </div>
                                            <div class="card-footer border-top pb-md-0">
                                                <h5>Total Sales</h5>
                                                <span class="text-primary text-bold-500">$82,950.96</span>
                                                <div class="progress progress-bar-primary progress-sm mt-50 mb-md-50">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="78" style="width:78%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Latest Update Starts -->
                        <div class="col-xl-4 col-md-6 col-12 dashboard-latest-update">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center pb-50">
                                    <h4 class="card-title">รายัรบรายจ่ายตามหมวด</h4>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButtonSec" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            2020
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButtonSec">
                                            <a class="dropdown-item" href="javascript:;">2020</a>
                                            <a class="dropdown-item" href="javascript:;">2019</a>
                                            <a class="dropdown-item" href="javascript:;">2018</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0 pb-1">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                            <div class="list-left d-flex">
                                                <div class="list-icon mr-1">
                                                    <div class="avatar bg-rgba-primary m-0">
                                                        <div class="avatar-content">
                                                            <i class="bx bxs-zap text-primary font-size-base"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-content">
                                                    <span class="list-title">Total Products</span>
                                                    <small class="text-muted d-block">2k New Products</small>
                                                </div>
                                            </div>
                                            <span>10k</span>
                                        </li>
                                        <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                            <div class="list-left d-flex">
                                                <div class="list-icon mr-1">
                                                    <div class="avatar bg-rgba-info m-0">
                                                        <div class="avatar-content">
                                                            <i class="bx bx-stats text-info font-size-base"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-content">
                                                    <span class="list-title">Total Sales</span>
                                                    <small class="text-muted d-block">39k New Sales</small>
                                                </div>
                                            </div>
                                            <span>26M</span>
                                        </li>
                                        <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                            <div class="list-left d-flex">
                                                <div class="list-icon mr-1">
                                                    <div class="avatar bg-rgba-danger m-0">
                                                        <div class="avatar-content">
                                                            <i class="bx bx-credit-card text-danger font-size-base"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-content">
                                                    <span class="list-title">Total Revenue</span>
                                                    <small class="text-muted d-block">43k New Revenue</small>
                                                </div>
                                            </div>
                                            <span>15M</span>
                                        </li>
                                        <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                            <div class="list-left d-flex">
                                                <div class="list-icon mr-1">
                                                    <div class="avatar bg-rgba-success m-0">
                                                        <div class="avatar-content">
                                                            <i class="bx bx-dollar text-success font-size-base"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-content">
                                                    <span class="list-title">Total Cost</span>
                                                    <small class="text-muted d-block">Total Expenses</small>
                                                </div>
                                            </div>
                                            <span>2B</span>
                                        </li>
                                        <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                            <div class="list-left d-flex">
                                                <div class="list-icon mr-1">
                                                    <div class="avatar bg-rgba-primary m-0">
                                                        <div class="avatar-content">
                                                            <i class="bx bx-user text-primary font-size-base"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-content">
                                                    <span class="list-title">Total Users</span>
                                                    <small class="text-muted d-block">New Users</small>
                                                </div>
                                            </div>
                                            <span>2k</span>
                                        </li>
                                        <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between">
                                            <div class="list-left d-flex">
                                                <div class="list-icon mr-1">
                                                    <div class="avatar bg-rgba-danger m-0">
                                                        <div class="avatar-content">
                                                            <i class="bx bx-edit-alt text-danger font-size-base"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-content">
                                                    <span class="list-title">Total Visits</span>
                                                    <small class="text-muted d-block">New Visits</small>
                                                </div>
                                            </div>
                                            <span>46k</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Earning Swiper Starts -->
                        
                    </div>
                </section>
                <!-- Dashboard Ecommerce ends -->

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

    <!-- BEGIN: Page JS-->
    <script src="../../../app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>