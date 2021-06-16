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

if($stage == 'list_noti'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['role'])) ||
        (!isset($_GET['hcode'])) ||
        (!isset($_GET['page'])) ||
        (!isset($_GET['limit']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $role = mysqli_real_escape_string($conn, $_GET['role']);
    $hcode = mysqli_real_escape_string($conn, $_GET['hcode']);
    $page = mysqli_real_escape_string($conn, $_GET['page']);
    $limit = mysqli_real_escape_string($conn, $_GET['limit']);

    if($role == 'admin'){
        $strSQL = "SELECT * FROM vot2_notification 
              WHERE 
              noti_allow_admin = '1' 
              AND noti_view = '0' 
              AND noti_type = 'workprocess'
              LIMIT $page, $limit
              ";
        $res = $db->fetch($strSQL, true, false);
        if(($res) && ($res['status'])){
            $return['status'] = 'Success';
            $return['data'] = $res['data'];
        }else{
            $return['status'] = 'Fail'.$strSQL;
        }
        echo json_encode($return);
        $db->close(); 
        die();
    }else if($role == 'manager'){
        $strSQL = "SELECT * FROM vot2_notification 
              WHERE 
              noti_view = '0' 
              AND noti_type = 'workprocess'
              AND nti_hcode IN (
                  SELECT phoscode FROM vot2_projecthospital WHERE hospcode = '$hcode'
              )
              LIMIT $page, $limit
              ";
        $res = $db->fetch($strSQL, true, false);
        if(($res) && ($res['status'])){
            $return['status'] = 'Success';
            $return['data'] = $res['data'];
        }else{
            $return['status'] = 'Fail';
        }
        echo json_encode($return);
        $db->close(); 
        die();
    }else if($role == 'staff'){
        $strSQL = "SELECT * FROM vot2_notification 
              WHERE 
              noti_view = '0' 
              AND noti_type = 'workprocess'
              AND nti_hcode = '$hcode'
              LIMIT $page, $limit
              ";
        $res = $db->fetch($strSQL, true, false);
        if(($res) && ($res['status'])){
            $return['status'] = 'Success';
            $return['data'] = $res['data'];
        }else{
            $return['status'] = 'Fail';
        }
        echo json_encode($return);
        $db->close(); 
        die();
    }
}