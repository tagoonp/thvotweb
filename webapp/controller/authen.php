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
    $username = mysqli_real_escape_string($conn, $_REQUEST['txtUsername']);
    $password = mysqli_real_escape_string($conn, $_REQUEST['txtPassword']);
    // $strSQL = "SELECT * FROM "
}

if($stage == 2){ // Checkcode

    $code = mysqli_real_escape_string($conn, $_REQUEST['txtCode']);
    $username = mysqli_real_escape_string($conn, $_REQUEST['txtUsername']);
    $password = mysqli_real_escape_string($conn, $_REQUEST['txtPassword1']);
    $fname = mysqli_real_escape_string($conn, $_REQUEST['txtFname']);
    $lname = mysqli_real_escape_string($conn, $_REQUEST['txtLname']);
    $email = mysqli_real_escape_string($conn, $_REQUEST['txtEmail']);
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
?>