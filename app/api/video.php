<?php 
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);
$return = array();

if($stage == 'startvideo'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['vid']))
    ){
        $return['status'] = 'Fail';
        $return['stage_fail'] = '0';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $vid = mysqli_real_escape_string($conn, $_GET['vid']);
    $return['status'] = 'Fail';
    
    $strSQL = "INSERT INTO vot2_videosession (`vs_session`, `vs_uid`, `vs_create`) VALUES ('$vid', '$uid', '$datetime')";
    $res1 = $db->insert($strSQL, false); 

    if($res1){
        $return['status'] = 'Success';
    }
    
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'cancelvideo'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['vid']))
    ){
        $return['status'] = 'Fail';
        $return['stage_fail'] = '0';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $vid = mysqli_real_escape_string($conn, $_GET['vid']);
    $return['status'] = 'Fail';
    
    $strSQL = "UPDATE vot2_videosession SET vs_upload = 'cancel' WHERE vs_session = '$vid' AND vs_uid = '$uid'";
    $res1 = $db->execute($strSQL); 
    $return['status'] = 'Success';
    
    echo json_encode($return);
    $db->close(); 
    die();

}

