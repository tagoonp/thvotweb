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

if($stage == 'profileimg'){

    // $json = file_get_contents('php://input');
    // $array = json_decode($json, true);

    // if(
    //     (!isset($array['uid']))
    // ){
    //     $return['status'] = 'Fail (x101)';
    //     echo json_encode($return);
    //     $db->close(); 
    //     die();
    // }




    if(
        (!isset($_POST['uid']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_POST['uid']);

    if($_FILES['file']){
        $path = '../uploads/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }


        $originalName = $_FILES['file']['name'];
        $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
        $t=time();
        $generatedName = md5($t.$originalName).$ext;
        $filePath = $path.$generatedName;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {

            $strSQL = "UPDATE vot2_account SET profile_img = '$generatedName' WHERE uid = '$uid'";
            $db->execute($strSQL);

            $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`) VALUES ('$datetime', 'เปลี่ยนรูปโปไฟล์', '', '$remote_ip', '$uid')";
            $db->insert($strSQL, false);

            echo json_encode(array(
                'result' => 'success',
                'status' => true,
            ));
        }
    }
    
    $db->close(); 
    die();
    /////

    $json = file_get_contents('php://input');
    $array = json_decode($json, true);

    if(
        (!isset($array['file'])) ||
        (!isset($array['uid']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $file = mysqli_real_escape_string($conn, $array['file']);
    $uid = mysqli_real_escape_string($conn, $array['uid']);

    $strSQL = "UPDATE vot2_account SET profile_img = '$file' WHERE uid = '$uid'";
    $db->execute($strSQL);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`) VALUES ('$datetime', 'เปลี่ยนรูปโปไฟล์', '', '$remote_ip', '$uid')";
    $db->insert($strSQL, false);

    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'savelocation'){
    $json = file_get_contents('php://input');
    $array = json_decode($json, true);

    if(
        (!isset($array['lat'])) ||
        (!isset($array['lng'])) ||
        (!isset($array['uid']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $lat = mysqli_real_escape_string($conn, $array['lat']);
    $lng = mysqli_real_escape_string($conn, $array['lng']);
    $uid = mysqli_real_escape_string($conn, $array['uid']);

    $strSQL = "DELETE FROM vot2_patient_location WHERE loc_patient_uid = '$uid'";
    $db->execute($strSQL);

    $strSQL = "SELECT * FROM vot2_account WHERE uid = '$uid'";
    $resp = $db->fetch($strSQL, false);
    if($resp){
        $username = $resp['username'];
        $strSQL = "INSERT INTO vot2_patient_location 
                (`loc_patient_uid`, `loc_patient_username`, `loc_lat`, `loc_lng`, `loc_udatetime`, `loc_status`)
                   VALUES (
                    '$uid', '$username', '$lat', '$lng', '$datetime', '1'
                   )
                  ";
        $db->insert($strSQL, false);

        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                       VALUES ('$datetime', 'ปรับปรุงพิกัดที่อยู่ผู้ป่วย', '', '$remote_ip', '$uid')
                      ";
        $db->insert($strSQL, false);

        $strSQL = "UPDATE vot2_account SET location_status = '0' WHERE uid = '$uid'";
        $db->execute($strSQL);
    }

    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'login_staff'){
    $json = file_get_contents('php://input');
    $array = json_decode($json, true);

    if(
        (!isset($array['username'])) ||
        (!isset($array['password']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $username = mysqli_real_escape_string($conn, $array['username']);
    $password = mysqli_real_escape_string($conn, $array['password']);

    $strSQL = "SELECT * FROM vot2_account WHERE (username = '$username' OR email = '$username') AND active_status = '1' AND verify_status = '1' AND delete_status = '0'";
    $result = $db->fetch($strSQL, false);
    if($result){
        if (password_verify($password, $result['password'])) {

            $return['status'] = 'Success';
            $return['thvot_session'] = session_id();
            $return['thvot_uid'] = $result['uid'];
            $return['thvot_role'] = $result['role'];
            $return['thvot_hcode'] = $result['hcode'];

            $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                       VALUES ('$datetime', 'เข้าสู่ระบบ (Mobile)', '', '$remote_ip', '".$result['uid']."')
                      ";
            $db->insert($strSQL, false);

            echo json_encode($return);
            $db->close();
            die();
        } else {
            $return['status'] = 'Fail (x102)';
            echo json_encode($return);
            $db->close(); 
            die();
        }
    }else{
        $return['status'] = 'Fail (x103)';
        echo json_encode($return);
        $db->close(); 
        die();
    }
}

if($stage == 'register_staff'){
    $json = file_get_contents('php://input');
    $array = json_decode($json, true);

    if(
        (!isset($array['username'])) ||
        (!isset($array['password'])) ||
        (!isset($array['fname'])) ||
        (!isset($array['lname'])) ||
        (!isset($array['phone'])) ||
        (!isset($array['hcode']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $username = mysqli_real_escape_string($conn, $array['username']);
    $password = mysqli_real_escape_string($conn, $array['password']);
    $fname = mysqli_real_escape_string($conn, $array['fname']);
    $lname = mysqli_real_escape_string($conn, $array['lname']);
    $phone = mysqli_real_escape_string($conn, $array['phone']);
    $hcode = mysqli_real_escape_string($conn, $array['hcode']);

    $strSQL = "SELECT * FROM vot2_account WHERE username = '$username' AND delete_status = '0' AND verify_status = '1' AND active_status = '1' LIMIT 1";
    $res1 = $db->fetch($strSQL, true, true);
    if(($res1) && ($res1['status']) && ($res1['count'] > 0)){
        $return['status'] = 'Duplicate)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $passwordlen = strlen($password);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $uid = base64_encode($dateuniversal.$hcode);

    $strSQL = "INSERT INTO vot2_account 
              (`uid`, `username`, `password`, `password_len`, `email`, 
              `phone`, `role`, `patient_type`, `hcode`, 
              `verify_status`, `active_status`, `u_datetime`, `p_udatetime`)
              VALUES (
                  '$uid', '$username', '$password', '$passwordlen', '$username', 
                  '$phone', 'staff', 'NA', '$hcode',
                  '0', '0', '$datetime', '$datetime'
              )
              ";
    $res = $db->insert($strSQL, false);
    if($res){
        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'สมัครใช้งานระบบ (Mobile)', '$fname $lname', '$remote_ip', '$uid')
                    ";
        $db->insert($strSQL, false);

        $strSQL = "INSERT INTO vot2_userinfo (`fname`, `lname`, `phone`, `info_udatetime`, `info_use`, `info_uid`) 
                   VALUES ('$fname', '$lname', '$phone', '$datetime', '1', '$uid')";
        $res = $db->insert($strSQL, false);

        $db->close();
        $return['status'] = 'Success';
        echo json_encode($return);
        die();
    }else{
        $return['status'] = 'Fail (x103)';
        echo json_encode($return);
        $db->close(); 
        die();
    }
}

if($stage == 'line_login'){
    $json = file_get_contents('php://input');
    $array = json_decode($json, true);

    if(
        (!isset($array['uid']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $array['uid']);

    $strSQL = "SELECT * FROM vot2_account WHERE uid = '$uid' AND active_status = '1' AND verify_status = '1' AND delete_status = '0'";
    $result = $db->fetch($strSQL, false);

    if($result){
        $return['status'] = 'Success';
        $return['thvot_session'] = session_id();
        $return['thvot_uid'] = $result['uid'];
        $return['thvot_role'] = $result['role'];
        $return['thvot_hcode'] = $result['hcode'];

        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'เข้าสู่ระบบ (Mobile)', '', '$remote_ip', '".$result['uid']."')
                    ";
        $db->insert($strSQL, false);

        echo json_encode($return);
        $db->close();
        die();
    }else{
        $return['status'] = 'Fail (x103)';
        echo json_encode($return);
        $db->close(); 
        die();
    }
}

if($stage == 'login'){

    $json = file_get_contents('php://input');
    $array = json_decode($json, true);

    if(
        (!isset($array['username'])) ||
        (!isset($array['password']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $username = mysqli_real_escape_string($conn, $array['username']);
    $password = mysqli_real_escape_string($conn, $array['password']);

    $strSQL = "SELECT * FROM vot2_account WHERE (username = '$username' OR email = '$username') AND active_status = '1' AND verify_status = '1' AND delete_status = '0'";
    $result = $db->fetch($strSQL, false);
    if($result){
        if (password_verify($password, $result['password'])) {

            $return['status'] = 'Success';
            $return['thvot_session'] = session_id();
            $return['thvot_uid'] = $result['uid'];
            $return['thvot_role'] = $result['role'];
            $return['thvot_hcode'] = $result['hcode'];

            $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                       VALUES ('$datetime', 'เข้าสู่ระบบ (Mobile)', '', '$remote_ip', '".$result['uid']."')
                      ";
            $db->insert($strSQL, false);

            echo json_encode($return);
            $db->close();
            die();
        } else {
            $return['status'] = 'Fail (x102)';
            echo json_encode($return);
            $db->close(); 
            die();
        }
    }else{
        $return['status'] = 'Fail (x103)';
        echo json_encode($return);
        $db->close(); 
        die();
    }
}


if($stage == 'logout'){
    if(
        (!isset($_REQUEST['uid']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_POST['uid']);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
               VALUES ('$datetime', 'ออกจากระบบ (Mobile)', '', '$remote_ip', '$uid')";
    $db->insert($strSQL, false);
    
    session_destroy();
    $db->close();
    $return['status'] = 'Success';
    echo json_encode($return);
    die();
}

if($stage == 'signup'){
    if(
        (!(isset($_POST['username']))) ||
        (!(isset($_POST['fname']))) ||
        (!(isset($_POST['lname']))) ||
        (!(isset($_POST['phone']))) ||
        (!(isset($_POST['email']))) ||
        (!(isset($_POST['password']))) ||
        (!(isset($_POST['hcode'])))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }


    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['hcode']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $strSQL = "SELECT * FROM vot2_account WHERE username = '$username' AND delete_status = '0' LIMIT 1";
    $res1 = $db->fetch($strSQL, true, true);
    if(($res1) && ($res1['status']) && ($res1['count'] > 0)){
        $return['status'] = 'Fail (x102)';
        echo json_encode($return);
        $db->close(); 
        die();
    }
    
    $passwordlen = strlen($password);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $uid = base64_encode($dateuniversal.$hcode);

    $strSQL = "INSERT INTO vot2_account 
              (`uid`, `username`, `password`, `password_len`, `email`, 
              `phone`, `role`, `patient_type`, `hcode`, 
              `verify_status`, `active_status`, `u_datetime`, `p_udatetime`)
              VALUES (
                  '$uid', '$username', '$password', '$passwordlen', '$email', 
                  '$phone', 'staff', 'NA', '$hcode',
                  '0', '0', '$datetime', '$datetime'
              )
              ";
    $res = $db->insert($strSQL, false);
    if($res){
        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'สมัครใช้งานระบบ', '$fname $lname', '$remote_ip', '$uid')
                    ";
        $db->insert($strSQL, false);

        $strSQL = "INSERT INTO vot2_userinfo (`fname`, `lname`, `phone`, `info_udatetime`, `info_use`, `info_uid`) 
                   VALUES ('$fname', '$lname', '$phone', '$datetime', '1', '$uid')";
        $res = $db->insert($strSQL, false);

        $db->close();
        $return['status'] = 'Success';
        echo json_encode($return);
        die();
    }else{
        $return['status'] = 'Fail (x103)';
        echo json_encode($return);
        $db->close(); 
        die();
    }
}

// Current loged in user information
if($stage == 'user'){
    $json = file_get_contents('php://input');
    $array = json_decode($json, true);

    if(
        (!isset($array['uid'])) ||
        (!isset($array['role']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $array['uid']);
    $role = mysqli_real_escape_string($conn, $array['role']);

    $strSQL = "SELECT * FROM vot2_account INNER JOIN vot2_chospital ON vot2_account.hcode = vot2_chospital.hoscode 
               INNER JOIN vot2_userinfo ON vot2_account.uid = vot2_userinfo.info_uid
               LEFT JOIN vot2_patient_location ON vot2_account.uid = vot2_patient_location.loc_patient_uid
               WHERE 
               vot2_account.UID = '$uid' 
               AND vot2_account.role = '$role'
               AND info_use = '1'
               AND (loc_status = '1' OR loc_status IS NULL)
               LIMIT 1
          ";
    $user = $db->fetch($strSQL, false);
    if($user){
        $return['status'] = 'Success';
        $return['data'] = $user;
    }else{
        $return['status'] = 'Fail (x102)';
    }
    echo json_encode($return);
    $db->close(); 
    die();
}

// Selected user information
if($stage == 'select_user'){
    if(
        (!isset($_REQUEST['uid']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_POST['uid']);

    $strSQL = "SELECT * FROM vot2_account INNER JOIN vot2_chospital ON vot2_account.hcode = vot2_chospital.hoscode 
               INNER JOIN vot2_userinfo ON vot2_account.uid = vot2_userinfo.info_uid
               WHERE 
               vot2_account.UID = '$uid'
               AND info_use = '1'
               LIMIT 1
          ";
    $user = $db->fetch($strSQL, false);
    if($user){
        $return['status'] = 'Success';
        $return['data'] = $user;
    }else{
        $return['status'] = 'Fail (x102)';
    }
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'update_password'){
    if(
        (!(isset($_POST['uid']))) ||
        (!(isset($_POST['password'])))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
       
    }
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $passwordlen = strlen($password);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $strSQL = "UPDATE vot2_account SET password = '$password', password_len = '$passwordlen' WHERE uid = '$uid'";
    $db->execute($strSQL);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`) VALUES ('$datetime', 'ปรับปรุงรหัสผ่าน', '', '$remote_ip', '$uid')";
    $db->insert($strSQL, false);

    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close();
    die();
}


