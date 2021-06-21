<?php 
require('../../../../../database_config/thvot/config.inc.php');
require('../../../config/configuration.php');
require('../../../config/database.php'); 
require('../../../config/patient.role.php'); 

$db = new Database();
$conn = $db->conn();

$stage = '1';
if((!isset($_GET['uid'])) || (!isset($_GET['patient_username']))){ 
    $db->close();
    header('Location: ../../../404.php');
    die();
}

$uid = mysqli_real_escape_string($conn, $_GET['uid']);
$patient_username = mysqli_real_escape_string($conn, $_GET['patient_username']);
$menu = 0;

$strSQL = "SELECT * FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
           WHERE 
           a.username = '$patient_username' 
           AND a.delete_status = '0' 
           AND b.info_use = '1'
           ";
$resu = $db->fetch($strSQL,false,true);
if(!$resu){
    $db->close();
    header('Location: ../../../404.php');
    die();
}

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
    <title>THVOT Patient calendar</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/calendars/tui-time-picker.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/calendars/tui-date-picker.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/calendars/tui-calendar.min.css"> -->
    <link rel="stylesheet" type="text/css" href="../../../assets/fullcalendar/fullcalendar.min.css">
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

    <style>
        .redEvent {
            background-color:#FF0000;
            opacity: 0.6;
            border: none;
        }
    </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body  style="background: #fff;" class="vertical-layout vertical-menu-modern 2-columns  navbar-sticky footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">


   <!-- BEGIN: Content-->
   <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper p-0 m-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="p-2">
                    <div class="row">
                        <div class="col-3"><img src="<?php echo $resu['profile_img'];?>" width="60" style="border-radius: 50%;"  alt=""></div>
                        <div class="col-9"><h4><?php echo $resu['fname']." ".$resu['lname']; ?></h4></div>
                    </div>
                </div>
                <!-- calendar Wrapper  -->
                <div class="calendar-wrapper position-relative">
                    <!-- calendar app overlay -->
                    <div class="app-content-overlay"></div>
                    <!-- calendar view start  -->
                    <div class="calendar-view p-1">
                        <!-- calendar view  -->
                        <div id="calendar" class="calendar-content"></div>
                    </div>
                    <!-- calendar view end  -->
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
    <input type="hidden" id="txtStartMon" value="<?php echo $resu['start_obsdate']; ?>">
    <input type="hidden" id="txtEndMon" value="<?php echo $resu['end_obsdate']; ?>">

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
    <script src="../../../assets/fullcalendar/fullcalendar.min.js"></script>
    <!-- END: Page JS-->

    <script>
        var calendar = ''
        $(document).ready(function(){
            calendar = $("#calendar").fullCalendar({
            // defaultView: 'agendaMonth',
            height: 'auto',
            header: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            eventRender: function(info) {
            info.el.querySelector('.fc-title').innerHTML = "<i>" + info.event.title + "</i>";
            },
            editable: false,
            allDaySlot: false,
            minTime : "08:00:00",
            maxTime : "17:00:00",
            height: 650,
            events: [
                {
                    title: '<i class="bx bxs-bell"></i>',
                    start: '2021-06-22',
                    // end: $('#txtEndMon').val(),
                    // backgroundColor: '#06c'
                    // className: ["redEvent"]
                },
                {
                    title: '',
                    start: $('#txtStartMon').val(),
                    end: $('#txtEndMon').val(),
                    // backgroundColor: '#06c'
                    className: ["redEvent"]
                }
            ]
            });
            calendar.fullCalendar('render');
        })
    </script>

</body>
<!-- END: Body-->

</html>