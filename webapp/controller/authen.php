<?php 
require("../../../database_config/thvot/config.inc.php");
require('../configuration/configuration.php');
require('../configuration/database.php'); 

$db = new Database();
$conn = $db->conn();

$stage = false;

if((!isset($_REQUEST['stage'])) || ($_REQUEST['stage'] == '') || ($_REQUEST['stage'] == null)){
    $db->close($conn);
    die();
}

$stage = mysqli_real_escape_string($conn, $_REQUEST['stage']);

if($stage == 1){ // Login
    if((!isset($_REQUEST['txtUsername'])) || (!isset($_REQUEST['txtPassword']))){
        $db->close($conn);
        die();
    }
    $username = mysqli_real_escape_string($conn, trim(strtolower($_REQUEST['txtUsername']), " "));
    $password = mysqli_real_escape_string($conn, $_REQUEST['txtPassword']);

    $strSQL = "SELECT * FROM vot2_account WHERE username = '$username' AND delete_status = '0' AND active_status = '1'";
    $result = $db->fetch($strSQL, false);
    if($result){
        if(password_verify($password, $result['password'])){

            $_SESSION['vot_sid'] = session_id();
            $_SESSION['vot_uid'] = $result['uid'];
            $_SESSION['vot_role'] = $result['role'];

            $strSQL = "INSERT INTO `vot2_log` (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`) 
                  VALUES ('$sysdatetime', 'ลงชื่อเข้าใช้งานระบบ', '', '$ip', '".$result['uid']."')
                  ";
            $db->insert($strSQL, false);

            $db->close($conn);
            header('Location: ../'.$result['role'].'/');
        }else{
            $db->close($conn);
            header('Location: ../?stage=fail2');
        }
       
    }else{
        $db->close($conn);
        header('Location: ../?stage=fail1');
    }
}

if($stage == 2){ // Register

    $code = mysqli_real_escape_string($conn, $_REQUEST['txtCode']);
    $username = mysqli_real_escape_string($conn, trim(strtolower($_REQUEST['txtUsername']), " "));
    $password = mysqli_real_escape_string($conn, $_REQUEST['txtPassword1']);
    $fname = mysqli_real_escape_string($conn, $_REQUEST['txtFname']);
    $lname = mysqli_real_escape_string($conn, $_REQUEST['txtLname']);
    $email = mysqli_real_escape_string($conn, trim(strtolower($_REQUEST['txtEmail']), " "));
    $phone = mysqli_real_escape_string($conn, $_REQUEST['txtPhone']);

    $options = [
        'cost' => 12,
    ];
    $password = password_hash($password, PASSWORD_BCRYPT, $options);
    $uid = base64_encode($config['dateuniversal']);
    $strSQL = "INSERT INTO vot2_account (`uid`, `username`, `password`, `email`, `phone`, `role`, `u_datetime`)
               VALUES ('$uid', '$username', '$password', '$email', '$phone', 'manager', '".$config['datetime']."')
              ";
    $result = $db->insert($strSQL, false);
    if($result){
        $strSQL = "INSERT INTO vot2_userinfo (`fname`, `lname`, `phone`, `info_udatetime`, `info_use`, `info_uid`)
               VALUES ('$fname', '$lname', '$phone', '".$config['datetime']."', '1', '$uid')
              ";
        $db->insert($strSQL, false);

        $strSQL = "INSERT INTO `vot2_log` (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`) 
                  VALUES ('$sysdatetime', 'ลงทะเบียนเพื่อใช้งานระบบ (Manager)', '', '$ip', '$uid')
                  ";
        // echo $strSQL;
        // die();
        $db->insert($strSQL, false);

        $strSQL = "UPDATE vot2_registercode SET regcode_use = '1', regcode_activedatetime = '$sysdatetime', regcode_activeby = '$uid' WHERE regcode_code = '$code'";
        $db->execute($strSQL);

        $_SESSION['vot_sid'] = session_id();
        $_SESSION['vot_uid'] = $uid;
        $_SESSION['vot_role'] = 'manager';

        $db->close($conn);
        header('Location: ../manager/');
    }
    echo $strSQL;
    $db->close($conn);
    die();
}

if($stage == 3){ // Log out

    $uid = $_SESSION['vot_uid'];

    $strSQL = "INSERT INTO `vot2_log` (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`) 
                  VALUES ('$sysdatetime', 'ออกจากระบบ', '', '$ip', '$uid')
                  ";
    $db->insert($strSQL, false);

    unset($_SESSION['vot_uid']);
    unset($_SESSION['vot_role']);
    session_destroy();
    $db->close($conn);
        header('Location: ../');
    die();
}

if($stage == 4){ // chage password

    $uid = $_SESSION['vot_uid'];
    $password = $_REQUEST['txtPassword1'];
    $len = strlen($password);
    $password = mysqli_real_escape_string($conn, $password);

    $options = [
        'cost' => 12,
    ];
    $password = password_hash($password, PASSWORD_BCRYPT, $options);

    $strSQL = "UPDATE vot2_account SET password = '$password', password_len = '$len', p_udatetime = '$sysdatetime' WHERE uid = '$uid'";
    $result = $db->execute($strSQL);
    if($result){
        $strSQL = "INSERT INTO `vot2_log` (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`) 
        VALUES ('$sysdatetime', 'เปลี่ยนรหัสผ่าน', '', '$ip', '$uid')
        ";
        $db->insert($strSQL, false);
    }
    
    $db->close($conn);
    header('Location: ../'.$_SESSION['vot_role'].'/account-security.php?stage=success');
    die();
}

?>