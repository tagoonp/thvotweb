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
        $return['stage_fail'] = '0';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $return['status'] = 'Fail';
    
    $strSQL = "SELECT hcode, obs_hcode, obs_uid FROM vot2_account WHERE uid = '$uid' AND delete_status = '0'";
    $res1 = $db->fetch($strSQL, false);
    if($res1){

        $obs_uid = $res1['obs_uid'];
        $obs_hcode = $res1['obs_hcode'];
        $hcode = $res1['hcode'];

        if($obs_uid != null){
            $strSQL = "SELECT a.phone, b.fname, b.lname FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                       WHERE 
                       a.uid = '$obs_uid' AND a.delete_status = '0' AND b.info_use = '1'";
            $res2 = $db->fetch($strSQL, false);
            if($res2){
                $return['obs_title'] = "พี่เลี้ยง";
                $return['obs_name'] = $res2['fname']." ".$res2['lname'];
                $return['obs_call'] = $res2['phone'];

                $strSQL = "SELECT hosname FROM vot2_chospital WHERE hoscode = '$obs_hcode'";
                $res3 = $db->fetch($strSQL, false);
                if($res3){
                    $return['obs_hoscode'] = $obs_hcode;
                    $return['obs_hosname'] = $res3['hosname'];
                }
            }else{
                $return['obs_info'] = $strSQL;
            }
        }else{
            $return['obs_info'] = 'Fail';
        }

        $strSQL = "SELECT a.phone, b.fname, b.lname FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                    WHERE 
                    hcode = '$hcode' AND a.delete_status = '0' AND b.info_use = '1' AND a.role = 'manager' ORDER BY a.ID DESC LIMIT 1";
        $res4 = $db->fetch($strSQL, false);
        if($res4){
            $return['care_title'] = "พยาบาลคลินิก";
            $return['care_name'] = $res4['fname']." ".$res2['lname'];
            $return['care_call'] = $res4['phone'];

            $strSQL = "SELECT hosname FROM vot2_chospital WHERE hoscode = '$hcode'";
            $res5 = $db->fetch($strSQL, false);
            if($res5){
                $return['care_hoscode'] = $hcode;
                $return['care_hosname'] = $res5['hosname'];
            }
        }else{
            $return['care_info'] = 'Fail'.$strSQL;
        }
        $return['status'] = 'Success';
    }else{
        $return['stage_fail'] = $strSQL;
    }
    
    echo json_encode($return);
    $db->close(); 
    die();

}

