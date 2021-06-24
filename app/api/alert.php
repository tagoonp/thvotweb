<?php 
session_start();
require('../../../database_config/thvot/config.inc.php');
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
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);

    $return['status'] = 'Fail';
    $strSQL = "SELECT * FROM vot2_alerttime WHERE alt_uid = '$uid'";
    $res1 = $db->fetch($strSQL, true, false);
    if(($res1) && ($res1['status'])){
        $return['status'] = 'Success';
        $return['data'] = $res1['data'];
    }
    
    echo json_encode($return);
    $db->close(); 
    die();

}
