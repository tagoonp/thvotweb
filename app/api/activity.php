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

if($stage == 'list'){
    if(
        (!isset($_GET['uid']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);

    $strSQL = "SELECT * FROM vot2_log WHERE log_uid = '$uid' ORDER BY log_datetime DESC LIMIT 100";
    $res = $db->fetch($strSQL, true, false);

    if(($res) && ($res['status'])){
        $return['status'] = 'Success';
        $return['data'] = $res['data'];
    }else{
        $return['status'] = 'Fail (x102)'.$strSQL;
    }
    echo json_encode($return);
    $db->close(); 
    die();

}