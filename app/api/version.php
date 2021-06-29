<?php 
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);
$return = array();

if($stage == 'checkversion'){
    if(
        (!isset($_GET['version']))
    ){
        $return['status'] = 'Fail';
        $return['stage_fail'] = '0';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $version = mysqli_real_escape_string($conn, $_GET['version']);
    $return['status'] = 'Fail';
    
    $strSQL = "SELECT * FROM vot2_version WHERE version_id = '$version' AND version_allow = '1' AND version_app = 'vot'";
    $res1 = $db->fetch($strSQL, true, false); 
    if(($res1) && ($res1['status'])){
        $return['status'] = 'Success';
    }else{
        $return['status'] = 'New version available';
    }
    
    echo json_encode($return);
    $db->close(); 
    die();

}

