<?php 
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
                       AND b.info_use = '1' AND a.delete_status = '0' AND a.role IN ('manager', 'staff', 'moderator')
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
                       WHERE a.hcode = '$hcode' AND b.info_use = '1' AND a.delete_status = '0' AND a.role IN ('manager', 'staff', 'moderator')
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
            WHERE b.info_use = '1' AND a.delete_status = '0' AND a.role IN ('manager', 'staff', 'moderator')
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

if($stage == 'user_info'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['user_uid']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $user_uid = mysqli_real_escape_string($conn, $_GET['user_uid']);

    $strSQL = "SELECT a.*, b.*, a.ID user_id, c.hosname, a.role user_role
               FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
               INNER JOIN vot2_chospital c ON a.hcode = c.hoscode
               WHERE a.uid = '$user_uid' 
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

    // $selected_user['location_status_c'] = '';
    // if($selected_user['location_status'] == 1){
    //     $selected_user['location_status_c'] = 'checked';
    // }

    // $selected_user['limg_status_c'] = '';
    // if($selected_user['profile_status'] == 1){
    //     $selected_user['limg_status_c'] = 'checked';
    // }

    $selected_user['active_status_c'] = '';
    if($selected_user['active_status'] == 1){
        $selected_user['active_status_c'] = 'checked';
    }

    $return['data'] = $selected_user;
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'user_delete'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['user_uid']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $user_uid = mysqli_real_escape_string($conn, $_GET['user_uid']);


    $strSQL = "UPDATE vot2_account SET delete_status = '1' WHERE uid = '$user_uid' ";
    $res = $db->execute($strSQL, false);

    $strSQL = "UPDATE vot2_userinfo SET info_use = '0' WHERE info_uid = '$user_uid' ";
    $res = $db->execute($strSQL, false);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
        VALUES ('$datetime', 'ลบผู้ใช้งานระบบ', 'Target TB NO : $user_uid', '$remote_ip', '$uid')
    ";
    $db->insert($strSQL, false);

    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'user_stage'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['user_uid'])) ||
        (!isset($_GET['var']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $user_uid = mysqli_real_escape_string($conn, $_GET['user_uid']);
    $var = mysqli_real_escape_string($conn, $_GET['var']);


    if($var == 'active'){

        $strSQL = "SELECT verify_status FROM vot2_account WHERE uid = '$user_uid' AND delete_status = '0'";
        $res = $db->fetch($strSQL, false);
        if($res){

            if($res['verify_status'] == '0'){
                $strSQL = "UPDATE vot2_account SET verify_status = '1' WHERE uid = '$user_uid' AND delete_status = '0'";
                $db->execute($strSQL);
            }
        }

        $strSQL = "SELECT active_status FROM vot2_account WHERE uid = '$user_uid' AND delete_status = '0'";
        $res = $db->fetch($strSQL, false);
        if($res){
            $c = $res['active_status'];
            $ts = '1';
            if($c == '1'){
                $ts = '0';
            }

            $strSQL = "UPDATE vot2_account SET active_status = '$ts' WHERE uid = '$user_uid' AND delete_status = '0'";
            $db->execute($strSQL);
            
        }
    }

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
        VALUES ('$datetime', 'ปรับปรุงสถานะ ($var)', 'USER UID : $user_uid', '$remote_ip', '$uid')
    ";
    $db->insert($strSQL, false);

    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die();
    
}