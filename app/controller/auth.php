<?php 
session_start();
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);

if($stage == 'login'){

    if(
        (!isset($_REQUEST['txtUsername'])) ||
        (!isset($_REQUEST['txtPassword']))
    ){
        $db->close(); header('Location: ../404?error=x101'); die();
    }

    $username = mysqli_real_escape_string($conn, $_POST['txtUsername']);
    $password = mysqli_real_escape_string($conn, $_POST['txtPassword']);

    $strSQL = "SELECT * FROM vot2_account WHERE (username = '$username' OR email = '$username') AND active_status = '1' AND verify_status = '1' AND delete_status = '0'";
    $result = $db->fetch($strSQL, false);
    if($result){
        if (password_verify($_POST["txtPassword"], $result['password'])) {
            $_SESSION['thvot_id'] = session_id();
            $_SESSION['thvot_uid'] = $result['uid'];
            $_SESSION['thvot_role'] = $result['role'];



            $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                       VALUES ('$datetime', 'เข้าสู่ระบบ', '', '$remote_ip', '".$_SESSION['thvot_uid']."')
                      ";
            $db->insert($strSQL, false);
            $db->close();
            header('Location: ../core/'.$result['role'].'/system/');
            die();
        } else {
        $db->close();
        header('Location: ../login.php?stage=fail2');
        die();
        }
    }else{
        $db->close();
        header('Location: ../login.php?stage=fail1');
        die();
    }

}else if($stage == 'logout'){


    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                       VALUES ('$datetime', 'ออกจากระบบ', '', '$remote_ip', '".$_SESSION['thvot_uid']."')
                      ";
            $db->insert($strSQL, false);

    unset($_SESSION['thvot_id']);
    unset($_SESSION['thvot_uid']);
    unset($_SESSION['thvot_role']);
    
    session_destroy();
    $db->close();
    header('Location: ../');
    die();

}else if($stage == 'signup'){

    if(
        (!isset($_REQUEST['txtFname'])) ||
        (!isset($_REQUEST['txtLname'])) ||
        (!isset($_REQUEST['txtHcode'])) ||
        (!isset($_REQUEST['txtEmail'])) ||
        (!isset($_REQUEST['txtUsername'])) ||
        (!isset($_REQUEST['txtPassword1'])) ||
        (!isset($_REQUEST['txtPhone']))
    ){
        $db->close(); header('Location: ../404?error=x103'); die();
    }

    $fname = mysqli_real_escape_string($conn, $_POST['txtFname']);
    $lname = mysqli_real_escape_string($conn, $_POST['txtFname']);
    $hcode = mysqli_real_escape_string($conn, $_POST['txtHcode']);
    $email = mysqli_real_escape_string($conn, $_POST['txtEmail']);
    $phone = mysqli_real_escape_string($conn, $_POST['txtPhone']);
    $username = mysqli_real_escape_string($conn, $_POST['txtUsername']);
    $password = mysqli_real_escape_string($conn, $_POST['txtPassword1']);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $uid = base64_encode($dateuniversal.$email);

    $strSQL = "SELECT * FROM czmod0_account WHERE (username = '$username' OR email = '$email') AND delete_status = '0' AND active_status = '1'" ;
    $result = $db->fetch($strSQL, true, true);
    if($result){
        if(sizeof($result['count']) > 0){
            $db->close(); header('Location: ../auth-register?stage=duplicate'); die();
        }
    }

    $strSQL = "INSERT INTO czmod0_account (`UID`, `username`, `password`, `hcode`, `email`, `phone`, `login_type`, `fname`, `lname`, `regdatetime`, `udatetime`, `role`)
               VALUES ('$uid', '$username', '$password', '$hcode', '$email', '$phone', 'email', '$fname', '$lname', '$datetime', '$datetime', 'guest')
              ";
    $result_insert = $db->insert($strSQL, false);

    if($result_insert){
        $_SESSION['thvot_id'] = session_id();
        $_SESSION['thvot_uid'] = $uid;
        $_SESSION['thvot_role'] = 'guest';
        $db->close();
        header('Location: ../core/guest/system/');
        die();
    }else{
        echo  $strSQL;
        die();
        $db->close(); header('Location: ../auth-register?stage=error'); die();
    }
    $db->close();
    header('Location: ../');
    die();
  
}else{
  $db->close(); header('Location: ../404?error=x909'); die();
}



?>