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
    // $page = $page - 1;
    // if($page != 1){
    //     $page = ($page - 1) * $limit;
    // }

    $page = ($page * $limit) - $limit;

    // if($page < 0){ $page = 0; }

    $strSQL = "SELECT role FROM vot2_account WHERE uid = '$uid'";
    $res1 = $db->fetch($strSQL, false);
    if($res1){
        $role = $res1['role'];
        if($role == 'manager'){
            $strSQL = "SELECT a.uid, a.username, a.profile_img, b.fname, b.lname, a.hcode, c.hosname , a.patient_type
                       FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                       INNER JOIN vot2_chospital c ON a.hcode = c.hoscode 
                       WHERE a.hcode IN (
                           SELECT phoscode FROM vot2_projecthospital WHERE hospcode = '$hcode'
                       )
                       AND b.info_use = '1' 
                       AND a.delete_status = '0' 
                       AND a.role = 'patient'
                       AND a.active_status = '1'
                       AND a.verify_status = '1'
                       LIMIT $page, $limit";
            $res = $db->fetch($strSQL,true,false);
            if(($res) && ($res['status'])){
                $return['status'] = 'Success';
                $return['data'] = $res['data'];
            }else{
                $return['status'] = 'Fail (x102)'.$strSQL;
            }
        }else if($role == 'staff'){
            $strSQL = "SELECT a.uid, a.username, a.profile_img, b.fname, b.lname, a.hcode, c.hosname , a.patient_type
                       FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                       INNER JOIN vot2_chospital c ON a.hcode = c.hoscode 
                       WHERE 
                       a.hcode = '$hcode' 
                       AND b.info_use = '1' 
                       AND a.delete_status = '0' 
                       AND a.role = 'patient'
                       AND a.active_status = '1'
                       AND a.verify_status = '1'
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
            $strSQL = "SELECT a.uid, a.username, a.profile_img, b.fname, b.lname, a.hcode, c.hosname , a.patient_type
            FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
            INNER JOIN vot2_chospital c ON a.hcode = c.hoscode 
            WHERE 
            b.info_use = '1' 
            AND a.delete_status = '0' 
            AND a.role = 'patient'
            AND a.active_status = '1'
            AND a.verify_status = '1'
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

if($stage == 'patient_info'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['patient_id']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $patient_id = mysqli_real_escape_string($conn, $_GET['patient_id']);

    $strSQL = "SELECT a.*, b.*, a.ID user_id, c.hosname
               FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
               INNER JOIN vot2_chospital c ON a.hcode = c.hoscode
               WHERE a.username = '$patient_id' 
               AND a.delete_status = '0' 
               AND b.info_use = '1'
               LIMIT 1";
    $selected_user = $db->fetch($strSQL, false);
    if(!$selected_user){
        $return['status'] = 'Fail (x102)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $return['status'] = 'Success';
    $return['data'] = $selected_user;
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'patient_location'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['patient_id']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $patient_id = mysqli_real_escape_string($conn, $_GET['patient_id']);


    $strSQL = "SELECT * FROM vot2_patient_location WHERE loc_patient_uid = '$patient_id' AND loc_status = '1'";
    $selected_location = $db->fetch($strSQL, false);

    if(!$selected_location){
        $return['status'] = 'Fail (x102)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $return['status'] = 'Success';
    $return['data'] = $selected_location;
    echo json_encode($return);
    $db->close(); 
    die();
}