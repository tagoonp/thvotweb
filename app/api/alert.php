<?php 
// session_start();
require('../config/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);
$return = array();

if($stage == 'getlist'){
    if(
        (!isset($_GET['uid']))
    ){
        $return['status'] = 'Fail';
        $return['stage_fail'] = '0';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $return['status'] = 'Fail';
    $strSQL = "SELECT * FROM vot2_alerttime WHERE alt_uid = '$uid' ORDER BY alt_recordtime";
    $res1 = $db->fetch($strSQL, true, false);
    if(($res1) && ($res1['status'])){
        $return['status'] = 'Success';
        $return['data'] = $res1['data'];
    }else{
        $return['stage_fail'] = '1'.$strSQL;
    }
    
    echo json_encode($return);
    $db->close(); 
    die();

}

if($stage == 'deletelist'){
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['alert_id']))
    ){
        $return['status'] = 'Fail';
        $return['stage_fail'] = '0';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $alert_id = mysqli_real_escape_string($conn, $_REQUEST['alert_id']);
    $return['status'] = 'Fail';

    $strSQL = "DELETE FROM vot2_alerttime WHERE alt_uid = '$uid' AND ID = '$alert_id' ";
    $res1 = $db->execute($strSQL);
    $return['status'] = 'Success';
    
    echo json_encode($return);
    $db->close(); 
    die();

}
