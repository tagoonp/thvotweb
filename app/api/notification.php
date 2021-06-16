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

if($stage == 'admin_notinumber'){
    $strSQL = "SELECT COUNT(noti_id) cnt FROM vot2_notification 
              WHERE 
              noti_allow_admin = '1' 
              AND noti_view = '0' 
              AND noti_type = 'workprocess'
              AND noti_allow_admin = '1'
              ";
    $res = $db->fetch($strSQL, false);
    if($res){
        if($res['cnt'] != null){
            $return['status'] = 'Success';
            $return['data']['cn'] = $res['cnt'];
        }else{
            $return['status'] = 'Success';
            $return['data']['cn'] = 0;
        }
    }else{
        $return['status'] = 'Success';
        $return['data']['cn'] = 0;
    }
    echo json_encode($return);
    $db->close(); 
    die();
}