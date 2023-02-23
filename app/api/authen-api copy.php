<?php 
require('../config/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);
$return = array();

if($stage == 'login'){
    echo "asd0";
    if(
        (!isset($_REQUEST['username'])) ||
        (!isset($_REQUEST['password']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $strSQL = "SELECT * FROM vot2_account WHERE (username = '$username' OR email = '$username') AND active_status = '1' AND verify_status = '1' AND delete_status = '0'";
    $result = $db->fetch($strSQL, false);
    if($result){
        if (password_verify($_POST["txtPassword"], $result['password'])) {

            $return['status'] = 'Success';
            $return['thvot_session'] = session_id();
            $return['thvot_uid'] = $result['uid'];
            $return['thvot_role'] = $result['role'];

            $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                       VALUES ('$datetime', 'เข้าสู่ระบบ (Mobile)', '', '$remote_ip', '".$_SESSION['thvot_uid']."')
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
    if(($res1['status']) && ($res1['count'] > 0)){
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
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['role']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $strSQL = "SELECT * FROM vot2_account INNER JOIN vot2_chospital ON vot2_account.hcode = vot2_chospital.hoscode 
               INNER JOIN vot2_userinfo ON vot2_account.uid = vot2_userinfo.info_uid
               WHERE 
               vot2_account.UID = '$uid' AND vot2_account.role = '$role'
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


