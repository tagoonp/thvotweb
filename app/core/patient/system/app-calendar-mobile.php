<?php 
require('../../../../../database_config/thvot/config.inc.php');
require('../../../config/configuration.php');
require('../../../config/database.php'); 
require('../../../config/patient.role.php'); 

$db = new Database();
$conn = $db->conn();

$stage = '1';
if(!isset($_GET['uid'])){ 
    $db->close();
    header('Location: ../../../404.php');
    die();
}
$uid = mysqli_real_escape_string($conn, $_GET['uid']);
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

    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/calendars/app-calendar.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-sticky footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">


   <!-- BEGIN: Content-->
   <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- calendar Wrapper  -->
                <div class="calendar-wrapper position-relative">
                    <!-- calendar app overlay -->
                    <div class="app-content-overlay"></div>
                    <!-- calendar sidebar start -->
                    <div id="sidebar" class="sidebar">
                        <div class="sidebar-new-schedule">
                            <!-- create new schedule button -->
                            <button id="btn-new-schedule" type="button" class="btn btn-primary btn-block sidebar-new-schedule-btn">
                                New schedule
                            </button>
                        </div>
                        <!-- sidebar calendar labels -->
                        <div id="sidebar-calendars" class="sidebar-calendars">
                            <div>
                                <div class="sidebar-calendars-item">
                                    <!-- view All checkbox -->
                                    <div class="checkbox">
                                        <input type="checkbox" class="checkbox-input tui-full-calendar-checkbox-square" id="checkbox1" value="all" checked>
                                        <label for="checkbox1">View all</label>
                                    </div>
                                </div>
                            </div>
                            <div id="calendarList" class="sidebar-calendars-d1"></div>
                        </div>
                        <!-- / sidebar calendar labels -->
                    </div>
                    <!-- calendar sidebar end -->
                    <!-- calendar view start  -->
                    <div class="calendar-view">
                        <div class="calendar-action d-flex align-items-center flex-wrap">
                            <!-- sidebar toggle button for small sceen -->
                            <button class="btn btn-icon sidebar-toggle-btn">
                                <i class="bx bx-menu font-large-1"></i>
                            </button>
                            <!-- dropdown button to change calendar-view -->
                            <div class="dropdown d-inline mr-75">
                                <button id="dropdownMenu-calendarType" class="btn btn-action dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i id="calendarTypeIcon" class="bx bx-calendar-alt"></i>
                                    <span id="calendarTypeName">Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu-calendarType">
                                    <li role="presentation">
                                        <a class="dropdown-menu-title dropdown-item" role="menuitem" data-action="toggle-daily">
                                            <i class="bx bx-calendar-alt mr-50"></i>
                                            <span>Daily</span>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a class="dropdown-menu-title dropdown-item" role="menuitem" data-action="toggle-weekly">
                                            <i class='bx bx-calendar-event mr-50'></i>
                                            <span>Weekly</span>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a class="dropdown-menu-title dropdown-item" role="menuitem" data-action="toggle-monthly">
                                            <i class="bx bx-calendar mr-50"></i>
                                            <span>Month</span>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a class="dropdown-menu-title dropdown-item" role="menuitem" data-action="toggle-weeks2">
                                            <i class='bx bx-calendar-check mr-50'></i>
                                            <span>2 weeks</span>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a class="dropdown-menu-title dropdown-item" role="menuitem" data-action="toggle-weeks3">
                                            <i class='bx bx-calendar-check mr-50'></i>
                                            <span>3 weeks</span>
                                        </a>
                                    </li>
                                    <li role="presentation" class="dropdown-divider"></li>
                                    <li role="presentation">
                                        <div role="menuitem" data-action="toggle-workweek" class="dropdown-item">
                                            <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-workweek" checked>
                                            <span class="checkbox-title bg-primary"></span>
                                            <span>Show weekends</span>
                                        </div>
                                    </li>
                                    <li role="presentation">
                                        <div role="menuitem" data-action="toggle-start-day-1" class="dropdown-item">
                                            <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-start-day-1">
                                            <span class="checkbox-title"></span>
                                            <span>Start Week on Monday</span>
                                        </div>
                                    </li>
                                    <li role="presentation">
                                        <div role="menuitem" data-action="toggle-narrow-weekend" class="dropdown-item">
                                            <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-narrow-weekend">
                                            <span class="checkbox-title"></span>
                                            <span>Narrower than weekdays</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- calenadar next and previous navigate button -->
                            <span id="menu-navi" class="menu-navigation">
                                <button type="button" class="btn btn-action move-today mr-50 px-75" data-action="move-today">Today</button>
                                <button type="button" class="btn btn-icon btn-action  move-day mr-50 px-50" data-action="move-prev">
                                    <i class="bx bx-chevron-left" data-action="move-prev"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-action move-day mr-50 px-50" data-action="move-next">
                                    <i class="bx bx-chevron-right" data-action="move-next"></i>
                                </button>
                            </span>
                            <span id="renderRange" class="render-range"></span>
                        </div>
                        <!-- calendar view  -->
                        <div id="calendar" class="calendar-content"></div>
                    </div>
                    <!-- calendar view end  -->
                </div>
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
    <script src="../../../app-assets/vendors/js/calendar/tui-code-snippet.min.js"></script>
    <script src="../../../app-assets/vendors/js/calendar/tui-dom.js"></script>
    <script src="../../../app-assets/vendors/js/calendar/tui-time-picker.min.js"></script>
    <script src="../../../app-assets/vendors/js/calendar/tui-date-picker.min.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/moment.min.js"></script>
    <script src="../../../app-assets/vendors/js/calendar/chance.min.js"></script>
    <script src="../../../app-assets/vendors/js/calendar/tui-calendar.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/scripts/configs/vertical-menu-light.js"></script>
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <script src="../../../app-assets/js/scripts/components.js"></script>
    <script src="../../../app-assets/js/scripts/footer.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="../../../app-assets/js/scripts/extensions/calendar/calendars-data.js"></script>
    <script src="../../../app-assets/js/scripts/extensions/calendar/schedules.js"></script>
    <script src="../../../app-assets/js/scripts/extensions/calendar/app-calendar.js"></script>
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>