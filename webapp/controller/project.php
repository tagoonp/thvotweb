<?php 
require("../../../database_config/thvot/config.inc.php");
require('../configuration/configuration.php');
require('../configuration/database.php'); 

$db = new Database();
$conn = $db->conn();

$stage = false;

if((!isset($_REQUEST['stage'])) || ($_REQUEST['stage'] == '') || ($_REQUEST['stage'] == null)){
    $db->close($conn);
    die();
}

$stage = mysqli_real_escape_string($conn, $_REQUEST['stage']);

if($stage == 1){ // Create project
    if(!isset($_REQUEST['txtProjectTitle'])){
        echo "Invalid parameters";
        $db->close($conn);
        die();
    }

    $uid = $_SESSION['vot_uid'];

    $title = mysqli_real_escape_string($conn, $_REQUEST['txtProjectTitle']);
    $detail = mysqli_real_escape_string($conn, $_REQUEST['txtProjectDesc']);

    $strSQL = "INSERT INTO `vot2_project` (`proj_title`, `proj_desc`, `proj_cdatetime`, `proj_udatetume`,  `proj_uid`) 
               VALUES ('$title', '$detail', '$sysdatetime', '$sysdatetime', '$uid')";
    $result = $db->insert($strSQL, true);
    if($result){
        $strSQL = "INSERT INTO `vot2_log` (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`) 
                  VALUES ('$sysdatetime', 'สร้างโครงการติดตามการรับประทานยา', 'รหัสโครงการ : $result <br>ชื่อโครงการ : $title', '$ip', '$uid')
                  ";
        $db->insert($strSQL, true);

        $_SESSION['vot_pid'] = $result;

        $db->close($conn);
        header('Location: ../manager/project-dashboard.php');
        die();
    }else{
        $db->close($conn);
        header('Location: ../manager/?stage=project_fail');
        die();
    }
}

if($stage == 2){ // Delete project
    if(!isset($_REQUEST['project_id'])){
        $db->close($conn);
        die();
    }
    $uid = $_SESSION['vot_uid'];
    $project_id = mysqli_real_escape_string($conn, $_REQUEST['project_id']);

    $strSQL = "UPDATE `vot2_project` SET proj_delete = '1' WHERE proj_id = '$project_id'";
    $result = $db->execute($strSQL);
    if($result){
        $strSQL = "INSERT INTO `vot2_log` (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`) 
                  VALUES ('$sysdatetime', 'ลบโครงการติดตามการรับประทานยา', 'รหัสโครงการ : $project_id', '$ip', '$uid')
                  ";
        $db->insert($strSQL, true);

        echo "Success";
        
    }

    $db->close($conn);
        die();
}

if($stage == 3){ // Create project session
    if((!isset($_REQUEST['pid'])) || (!isset($_REQUEST['next']))){
        echo "Invalid parameters";
        $db->close($conn);
        die();
    }
    $_SESSION['vot_pid'] = $_REQUEST['pid'];

    $db->close($conn);
    header('Location: ../manager/'.$_REQUEST['next']);
    die();
}