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
        (!isset($_GET['uid'])) ||
        (!isset($_GET['hcode']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $hcode = mysqli_real_escape_string($conn, $_GET['hcode']);
    $page = mysqli_real_escape_string($conn, $_GET['page']);
    $limit = mysqli_real_escape_string($conn, $_GET['limit']);
    $page = ($page * $limit) - $limit;

    $strSQL = "SELECT role FROM vot2_account WHERE uid = '$uid'";
    $res1 = $db->fetch($strSQL, false);
    if($res1){
        $role = $res1['role'];
        if($role == 'manager'){
            $strSQL = "SELECT a.uid, a.profile_img, b.fname, b.lname, a.hcode, c.hosname , a.patient_type, a.role
                       FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                       INNER JOIN vot2_chospital c ON a.hcode = c.hoscode 
                       WHERE a.hcode IN (
                           SELECT phoscode FROM vot2_projecthospital WHERE hospcode = '$hcode'
                       )
                       AND b.info_use AND a.delete_status = '0' AND a.role != 'patient' AND a.role != 'admin'
                       LIMIT $page, $limit";
            $res = $db->fetch($strSQL,true,false);
            if(($res) && ($res['status'])){
                $return['status'] = 'Success';
                $return['data'] = $res['data'];
            }else{
                $return['status'] = 'Fail (x102)'.$strSQL;
            }
        }else if($role == 'staff'){
            $strSQL = "SELECT a.uid, a.profile_img, b.fname, b.lname, a.hcode, c.hosname , a.patient_type, a.role
                       FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                       INNER JOIN vot2_chospital c ON a.hcode = c.hoscode 
                       WHERE a.hcode = '$hcode' AND b.info_use AND a.delete_status = '0' AND a.role = 'patient' AND a.role != 'admin'
                       LIMIT $page, $limit";
            $res = $db->fetch($strSQL,true,false);
            if(($res) && ($res['status'])){
                $return['status'] = 'Success';
                $return['data'] = $res['data'];
            }else{
                $return['status'] = 'Fail (x102)'.$strSQL;
            }
        }else if($role == 'moderator'){
            // $strSQL = "SELECT a.uid, a.profile_img, b.fname, b.lname, a.hcode, c.hosname 
            //            FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
            //            INNER JOIN vot2_chospital c ON a.hcode = c.hoscode 
            //            WHERE a.hcode IN (
            //                SELECT phoscode FROM vot2_projecthospital WHERE hospcode = '$hcode'
            //            )
            //            AND b.info_use AND a.delete_status = '0' AND a.role = 'patient'
            //            LIMIT $page, $limit";
        }else if($role == 'admin'){
            $strSQL = "SELECT a.uid, a.profile_img, b.fname, b.lname, a.hcode, c.hosname , a.patient_type, a.role
            FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
            INNER JOIN vot2_chospital c ON a.hcode = c.hoscode 
            WHERE b.info_use AND a.delete_status = '0' AND a.role = 'patient' AND a.role != 'admin'
            LIMIT $page, $limit";
            $res = $db->fetch($strSQL,true,false);
            if(($res) && ($res['status'])){
                $return['status'] = 'Success';
                $return['data'] = $res['data'];
            }else{
                $return['status'] = 'Fail (x102)'.$strSQL;
            }
        }
    }

    
    
    echo json_encode($return);
    $db->close(); 
    die();

}