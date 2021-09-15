<?php 
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);
$return = array();

if($stage == 'user_reshcode'){
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['hcode']))
        (!isset($_REQUEST['role']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $staff_id = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $hcode = mysqli_real_escape_string($conn, $_REQUEST['hcode']);
    $role = mysqli_real_escape_string($conn, $_REQUEST['role']);

    $buffhcode1 = array();

    if($role == 'manager'){
        $strSQL = "SELECT phoscode, hserv FROM vot2_projecthospital WHERE hospcode = '$hcode' ";
        $res = $db->fetch($strSQL, true, false);
        if(($res) && ($res['status'])){
            foreach ($res['data'] as $row) {
                $buffhcode2 = array();
                $buffhcode2['hcode'] = $row['phoscode'];
                $buffhcode2['hname'] = $row['hserv'];
                $buffhcode1[] = $buffhcode;
            }
        }
        // $strSQL = "";
    }else if($role == 'staff'){
        
    }
}

if($stage == 'update'){
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['username'])) ||
        (!isset($_REQUEST['fname'])) ||
        (!isset($_REQUEST['lname'])) ||
        (!isset($_REQUEST['phone'])) ||
        (!isset($_REQUEST['role']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $staff_id = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $username = mysqli_real_escape_string($conn, $_REQUEST['username']);
    $fname = mysqli_real_escape_string($conn, $_REQUEST['fname']);
    $lname = mysqli_real_escape_string($conn, $_REQUEST['lname']);
    $role = mysqli_real_escape_string($conn, $_REQUEST['role']);
    $phone = mysqli_real_escape_string($conn, $_REQUEST['phone']);
    $status = mysqli_real_escape_string($conn, $_REQUEST['status']);
    $verify = mysqli_real_escape_string($conn, $_REQUEST['verify']);
    $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
    $hcode = mysqli_real_escape_string($conn, $_REQUEST['hcode']);

    $strSQL = "SELECT * FROM vot2_account WHERE username = '$username' AND delete_status = '0'";
    $res1 = $db->fetch($strSQL, false, false);
    if($res1){
        $strSQL = "UPDATE vot2_account SET hcode = '$hcode', phone = '$phone', role = '$role', verify_status = '$verify', active_status = '$status' WHERE username = '$username'";
        $res = $db->execute($strSQL);

        $strSQL = "UPDATE vot2_userinfo SET info_use = '0' WHERE info_uid = '".$res1['uid']."'";
        $res = $db->execute($strSQL);

        $strSQL = "INSERT INTO vot2_userinfo (`fname`, `lname`, `phone`, `info_udatetime`, `info_use`, `info_uid`) 
                   VALUES ('$fname', '$lname', '$phone', '$datetime', '1', '".$res1['uid']."')";
        $res = $db->insert($strSQL, false);

        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'ลงทะเบียนผู้ใช้งานใหม่', '$fname $lname ('".$res1['uid']."')', '$remote_ip', '$staff_id')
                    ";
        $db->insert($strSQL, false);

        $return['status'] = 'Success';

    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '4';
        $return['error_msg'] = $strSQL;
    }

    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'create'){
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['username'])) ||
        (!isset($_REQUEST['password'])) ||
        (!isset($_REQUEST['fname'])) ||
        (!isset($_REQUEST['lname'])) ||
        (!isset($_REQUEST['phone'])) ||
        (!isset($_REQUEST['role']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $staff_id = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $username = mysqli_real_escape_string($conn, $_REQUEST['username']);
    $password = mysqli_real_escape_string($conn, $_REQUEST['password']);
    $fname = mysqli_real_escape_string($conn, $_REQUEST['fname']);
    $lname = mysqli_real_escape_string($conn, $_REQUEST['lname']);
    $role = mysqli_real_escape_string($conn, $_REQUEST['role']);
    $phone = mysqli_real_escape_string($conn, $_REQUEST['phone']);
    $status = mysqli_real_escape_string($conn, $_REQUEST['status']);
    $verify = mysqli_real_escape_string($conn, $_REQUEST['verify']);
    $email = mysqli_real_escape_string($conn, $_REQUEST['email']);
    $hcode = mysqli_real_escape_string($conn, $_REQUEST['hcode']);

    $strSQL = "SELECT * FROM vot2_account WHERE username = '$username' AND delete_status = '0'";
    $res = $db->fetch($strSQL, true, true);
    if(($res) && ($res['status'])){
        $return['status'] = 'Duplicate';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = base64_encode($dateuniversal.$username);
    $passwordlen = strlen($password);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $strSQL = "INSERT INTO vot2_account 
               (
                   `uid`, `username`, `password`, `password_len`, `email`, 
                   `phone`, `role`, `hcode`, `profile_img`, `verify_status`, 
                   `active_status`, `u_datetime`, `p_udatetime`, `reg_type`
               ) 
               VALUES 
               (
                   '$uid', '$username', '$password', '$passwordlen', '$email', 
                   '$phone', '$role', '$hcode', 'https://thvot.com/thvotweb/app/uploads/usertemp.png', '$verify', 
                   '$status', '$datetime', '$datetime', 'manual'
               )
              ";

    $res = $db->insert($strSQL, false);
    if($res){

        $strSQL = "INSERT INTO vot2_userinfo (`fname`, `lname`, `phone`, `info_udatetime`, `info_use`, `info_uid`) 
                   VALUES ('$fname', '$lname', '$phone', '$datetime', '1', '$uid')";
        $res = $db->insert($strSQL, false);

        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'ลงทะเบียนผู้ใช้งานใหม่', '$fname $lname ($uid)', '$remote_ip', '$staff_id')
                    ";
        $db->insert($strSQL, false);

        $return['status'] = 'Success';
        $return['uid'] = $uid;
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '4';
        $return['error_msg'] = $strSQL;
    }
    echo json_encode($return);
    $db->close(); 
    die();
}

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

if($stage == 'user_province'){
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['role'])) ||
        (!isset($_REQUEST['hcode']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $role = mysqli_real_escape_string($conn, $_REQUEST['role']);
    $hcode = mysqli_real_escape_string($conn, $_REQUEST['hcode']);

    $strSQL = "SELECT b.ap_code province_code, c.Name province_name
               FROM 
               vot2_chospital a INNER JOIN vot2_active_province b ON a.provcode = b.ap_code
               INNER JOIN vot2_changwat d ON b.ap_code = c.Changwat
               WHERE a.hoscode = '$hcode'
               ";
    $res = $db->fetch($strSQL, false, false);
    if($res){
        $return['status'] = 'Success';
        $return['data'] = $res;
    }else{
        $return['status'] = 'Fail (x102)';
    }
    echo json_encode($return);
    $db->close(); 
    die();
}