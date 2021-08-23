<?php 
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);


if($stage == 'line_login_staff'){
    $token = mysqli_real_escape_string($conn, $_GET['token']);
    $photo = mysqli_real_escape_string($conn, $_GET['photo']);
    $t = mysqli_real_escape_string($conn, $_GET['t']);

    $strSQL = "SELECT * FROM vot2_account WHERE uid = '$token' AND delete_status = '0' LIMIT 1";
    $result = mysqli_query($conn, $strSQL);

    $t = $_SESSION['reg_type'];

    if(($result) && (mysqli_num_rows($result) > 0)){
        // Already registered
        mysqli_close($conn);
        header('Location: ../staff_info?uid=' . $token . '&referal=webapp&photo='.$photo);
        die();
    }else{
        mysqli_close($conn);
        header('Location: ../register_staff?uid=' . $token . '&referal=webapp&photo='.$photo);
        die();
    }
}

if($stage == 'patient_session'){
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['role'])) ||
        (!isset($_REQUEST['hcode']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $role = mysqli_real_escape_string($conn, $_REQUEST['role']);
    $hcode = mysqli_real_escape_string($conn, $_REQUEST['hcode']);

    $_SESSION['thvot_session'] = session_id();
    $_SESSION['thvot_uid'] = $uid;
    $_SESSION['thvot_role'] = $role;
    $_SESSION['thvot_hcode'] = $hcode;

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
               VALUES ('$datetime', 'เข้าสู่ระบบ (Mobile)', '', '$remote_ip', '$uid')
              ";
    $db->insert($strSQL, false);
    header('Location: ../../patient/core/system/web/'.$result['role'].'/');
    $db->close();
    die();

}

if($stage == 'line_login'){

    $token = mysqli_real_escape_string($conn, $_GET['token']);
    $photo = mysqli_real_escape_string($conn, $_GET['photo']);
    $t = mysqli_real_escape_string($conn, $_GET['t']);

    $strSQL = "SELECT * FROM vot2_account WHERE uid = '$token' AND delete_status = '0' LIMIT 1";
    $result = mysqli_query($conn, $strSQL);

    $t = $_SESSION['reg_type'];

    if(($result) && (mysqli_num_rows($result) > 0)){
        // Already registered
        mysqli_close($conn);
        header('Location: ../register_patient_success?uid=' . $token . '&referal=webapp&photo='.$photo);
        die();
    }else{
        mysqli_close($conn);
        header('Location: ../register_patient?uid=' . $token . '&referal=webapp&photo='.$photo);
        die();
    }

}

if($stage == 'login'){

    if(
        (!isset($_POST['txtUsername'])) ||
        (!isset($_POST['txtPassword']))
    ){
        ?>
        <script>
            alert('ไม่สามารถเข้าสู่ระบบได้');
            window.history.back()
        </script>
        <?php
        $db->close();
        die();
    }

    $username = mysqli_real_escape_string($conn, $_POST['txtUsername']);
    $password = mysqli_real_escape_string($conn, $_POST['txtPassword']);

    $strSQL = "SELECT * FROM vot2_account WHERE (username = '$username' OR email = '$username') AND active_status = '1' AND role != 'patient' AND verify_status = '1' AND delete_status = '0'";
    $result = $db->fetch($strSQL, false);
    if($result){
        if (password_verify($password, $result['password'])) {

            $_SESSION['thvot_session'] = session_id();
            $_SESSION['thvot_uid'] = $result['uid'];
            $_SESSION['thvot_role'] = $result['role'];
            $_SESSION['thvot_hcode'] = $result['hcode'];

            $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                       VALUES ('$datetime', 'เข้าสู่ระบบ (Mobile)', '', '$remote_ip', '".$result['uid']."')
                      ";
            $db->insert($strSQL, false);
            header('Location: ../core/system/web/'.$result['role'].'/');
            $db->close();
            die();
        } else {
            ?>
            <script>
                alert('รหัสผ่านไม่ถูกต้อง');
                window.history.back()
            </script>
            <?php
            $db->close();
            die();
        }
    }else{

        echo $strSQL;
        die();

        ?>
        <script>
            alert('ไม่พบบัญชีผู้ใช้งานหรือข้อมูลไม่ถูกต้อง');
            window.history.back()
        </script>
        <?php
        $db->close();
        die();

    }

}

if($stage == 'signup_dot'){
    if(
        (!isset($_REQUEST['txtFname'])) ||
        (!isset($_REQUEST['txtLname'])) ||
        (!isset($_REQUEST['txtHcode'])) ||
        (!isset($_REQUEST['txtUid'])) ||
        (!isset($_REQUEST['txtHn'])) ||
        (!isset($_REQUEST['txtProvince'])) ||
        (!isset($_REQUEST['txtPhone'])) ||
        (!isset($_REQUEST['txtDist'])) ||
        (!isset($_REQUEST['txtSubdist'])) ||
        (!isset($_REQUEST['txtPhoto']))
    ){
        $db->close(); header('Location: ../404?error=x103'); die();
    }

    $fname = mysqli_real_escape_string($conn, $_POST['txtFname']);
    $lname = mysqli_real_escape_string($conn, $_POST['txtLname']);
    $hcode = mysqli_real_escape_string($conn, $_POST['txtHcode']);
    $hn = mysqli_real_escape_string($conn, $_POST['txtHn']);
    $uid = mysqli_real_escape_string($conn, $_POST['txtUid']);
    
    $phone = mysqli_real_escape_string($conn, $_POST['txtPhone']);
    $dist = mysqli_real_escape_string($conn, $_POST['txtDist']);
    $subdist = mysqli_real_escape_string($conn, $_POST['txtSubdist']);
    $tprovince = mysqli_real_escape_string($conn, $_POST['txtProvince']);
    $photo = mysqli_real_escape_string($conn, $_POST['txtPhoto']);

    $strSQL = "SELECT * FROM vot2_account WHERE uid = '$uid' AND role = 'patient' AND delete_status = '0'";
    $res = $db->fetch($strSQL, true, true);
    if(($res) && ($res['status']) && ($res['count'] > 0)){
        mysqli_close($conn);
        header('Location: ../dot_info?uid=' . $uid . '&referal=webapp');
        die();
    }

    $password = $dateuniversal;
    $passwordlen = strlen($password);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $endmondate = Date("Y-m-d", strtotime("$date +4 Month"));    

    $strSQL = "INSERT INTO vot2_account 
              (`uid`, `username`, `password`, `password_len`, `email`, 
              `phone`, `role`, `patient_type`, `hcode`, `profile_img`, 
              `verify_status`, `active_status`, `line_token`, `u_datetime`, `p_udatetime`, `start_obsdate`, `end_obsdate`, `cal_end_obsdate`)
              VALUES (
                  '$uid', '$hn', '$password', '$passwordlen', '', 
                  '$phone', 'patient', 'DOT', '$hcode', '$photo',
                  '1', '0', '$uid', '$datetime', '$datetime', '$date', '$endmondate', '$endmondate'
              )
              ";
    $res = $db->insert($strSQL, false);
    if($res){
        $strSQL = "UPDATE vot2_userinfo SET info_use = '0' WHERE info_uid = '$uid'";
        $db->execute($strSQL);

        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'ลงทะเบียนบัญชีผู้ใช้งาน DOT', '$fname $lname', '$remote_ip', '$uid')
                    ";
        $db->insert($strSQL, false);

        $strSQL = "INSERT INTO vot2_userinfo (`fname`, `lname`, `phone`, `info_udatetime`, `info_use`, `info_prov`, `info_district`, `info_subdistrict`, `info_uid`) 
                   VALUES ('$fname', '$lname', '$phone', '$datetime', '1', '$tprovince', '$dist', '$subdist', '$uid')";
        $res = $db->insert($strSQL, false);
        mysqli_close($conn);
        header('Location: ../dot_info?uid=' . $uid . '&referal=webapp');
        die();
    }else{
        // echo $strSQL;
        die();
        ?>
        <script>
            alert('Can not create new account');
            window.history.back()
        </script>
        <?php
        $db->close();
        die();
    }
}

if($stage == 'signup_staff'){
    if(
        (!isset($_REQUEST['txtFname'])) ||
        (!isset($_REQUEST['txtLname'])) ||
        (!isset($_REQUEST['txtHcode'])) ||
        (!isset($_REQUEST['txtUid'])) ||
        (!isset($_REQUEST['txtUsername'])) ||
        (!isset($_REQUEST['txtPassword'])) ||
        (!isset($_REQUEST['txtPhone'])) ||
        (!isset($_REQUEST['txtPhoto']))
    ){
        $db->close(); header('Location: ../404?error=x103'); die();
    }

    $fname = mysqli_real_escape_string($conn, $_POST['txtFname']);
    $lname = mysqli_real_escape_string($conn, $_POST['txtLname']);
    $hcode = mysqli_real_escape_string($conn, $_POST['txtHcode']);
    $uid = mysqli_real_escape_string($conn, $_POST['txtUid']);
    
    $phone = mysqli_real_escape_string($conn, $_POST['txtPhone']);

    $username = mysqli_real_escape_string($conn, $_POST['txtUsername']);
    $password = mysqli_real_escape_string($conn, $_POST['txtPassword']);
    $photo = mysqli_real_escape_string($conn, $_POST['txtPhoto']);
    $role = mysqli_real_escape_string($conn, $_POST['txtRole']);

    $strSQL = "SELECT * FROM vot2_account WHERE uid = '$uid' AND role IN ('staff', 'admin', 'manager', 'moderator') AND delete_status = '0'";
    $res = $db->fetch($strSQL, true, true);
    if(($res) && ($res['status']) && ($res['count'] > 0)){

        mysqli_close($conn);
        header('Location: ../staff_info?uid=' . $uid . '&referal=webapp');
        die();
       
    }

    $passwordlen = strlen($password);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $endmondate = Date("Y-m-d", strtotime("$date +4 Month"));  

    $strSQL = "INSERT INTO vot2_account 
              (`uid`, `username`, `password`, `password_len`, `email`, 
              `phone`, `relative_phone`, `role`, `hcode`,  `profile_img`, 
              `verify_status`, `active_status`, `line_token`, `u_datetime`, `p_udatetime`, `start_obsdate`, `end_obsdate`, `cal_end_obsdate`)
              VALUES (
                  '$uid', '$username', '$password', '$passwordlen', '', 
                  '$phone', '$phone2', '$role', '$hcode', '$photo',
                  '0', '0', '$uid', '$datetime', '$datetime', '$date', '$endmondate', '$endmondate'
              )
              ";
    $res = $db->insert($strSQL, false);
    if($res){

        $strSQL = "UPDATE vot2_userinfo SET info_use = '0' WHERE info_uid = '$uid'";
        $db->execute($strSQL);

        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'ลงทะเบียนบัญชีผู้ใช้งาน', '$fname $lname', '$remote_ip', '$uid')
                    ";
        $db->insert($strSQL, false);

        $strSQL = "INSERT INTO vot2_userinfo (`fname`, `lname`, `phone`, `info_udatetime`, `info_use`, `info_uid`) 
                   VALUES ('$fname', '$lname', '$phone', '$datetime', '1', '$uid')";
        $res = $db->insert($strSQL, false);

        $strSQL = "INSERT INTO vot2_notification 
                    (
                        `noti_header`, `noti_content`, `noti_datetime`, `noti_view`, `noti_type`, `noti_allow_admin`, 
                        `noti_specific_uid`, `noti_url`, `noti_hcode`
                    )
                    VALUES 
                    (
                        'แจ้งเตือนการสมัครใช้งาน', 'โดยคุณ$fname $lname', '$datetime', '0', 'workprocess', '1',
                        '', '', '$hcode'
                    )
                    ";

        $res = $db->insert($strSQL, false);
        
        mysqli_close($conn);
        header('Location: ../staff_info?uid=' . $uid . '&referal=webapp');
        die();
    }else{
        die();
        ?>
        <script>
            alert('Can not create new account');
            window.history.back()
        </script>
        <?php
        $db->close();
        die();
    }
}

if($stage == 'signup_vot'){
    if(
        (!isset($_REQUEST['txtFname'])) ||
        (!isset($_REQUEST['txtLname'])) ||
        (!isset($_REQUEST['txtHcode'])) ||
        (!isset($_REQUEST['txtUid'])) ||
        (!isset($_REQUEST['txtHn'])) ||
        (!isset($_REQUEST['txtUsername'])) ||
        (!isset($_REQUEST['txtPassword1'])) ||
        (!isset($_REQUEST['txtProvince'])) ||
        (!isset($_REQUEST['txtPhone'])) ||
        (!isset($_REQUEST['txtDist'])) ||
        (!isset($_REQUEST['txtSubdist'])) ||
        (!isset($_REQUEST['txtPhoto'])) ||
        (!isset($_REQUEST['txtPatientType'])) ||
        (!isset($_REQUEST['txtHcode2']))
    ){
        $db->close(); header('Location: ../404?error=x103'); die();
    }

    $fname = mysqli_real_escape_string($conn, $_POST['txtFname']);
    $lname = mysqli_real_escape_string($conn, $_POST['txtLname']);
    $hcode = mysqli_real_escape_string($conn, $_POST['txtHcode']);
    $hn = mysqli_real_escape_string($conn, $_POST['txtHn']);
    $uid = mysqli_real_escape_string($conn, $_POST['txtUid']);
    
    $phone = mysqli_real_escape_string($conn, $_POST['txtPhone']);
    $phone2 = mysqli_real_escape_string($conn, $_POST['txtPhone2']);
    $dist = mysqli_real_escape_string($conn, $_POST['txtDist']);
    $subdist = mysqli_real_escape_string($conn, $_POST['txtSubdist']);
    $tprovince = mysqli_real_escape_string($conn, $_POST['txtProvince']);

    $username = mysqli_real_escape_string($conn, $_POST['txtUsername']);
    $password = mysqli_real_escape_string($conn, $_POST['txtPassword1']);
    $photo = mysqli_real_escape_string($conn, $_POST['txtPhoto']);

    $patienttype = mysqli_real_escape_string($conn, $_POST['txtPatientType']);
    $obs_hcode = mysqli_real_escape_string($conn, $_POST['txtHcode2']);
    $obs_uid = mysqli_real_escape_string($conn, $_POST['txtObserver']);

    $strSQL = "SELECT * FROM vot2_account WHERE uid = '$uid' AND role = 'patient' AND delete_status = '0'";
    $res = $db->fetch($strSQL, true, true);
    if(($res) && ($res['status']) && ($res['count'] > 0)){
        mysqli_close($conn);
        header('Location: ../patient_info?uid=' . $uid . '&referal=webapp');
        die();
    }

    $passwordlen = strlen($password);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $endmondate = Date("Y-m-d", strtotime("$date +2 Month"));  

    $strSQL = "INSERT INTO vot2_account 
              (`uid`, `username`, `hn`, `password`, `password_len`, `email`, 
              `phone`, `relative_phone`, `role`, `patient_type`, `hcode`,  `profile_img`, 
              `verify_status`, `active_status`, `line_token`, `u_datetime`, `p_udatetime`, `start_obsdate`, `end_obsdate`, `cal_end_obsdate`
              `obs_hcode`, `obs_uid`)
              VALUES (
                  '$uid', '$username', '$hn', '$password', '$passwordlen', '', 
                  '$phone', '$phone2', 'patient', '$patienttype', '$hcode', '$photo',
                  '1', '1', '$uid', '$datetime', '$datetime', '$date', '$endmondate', '$endmondate',
                  '$obs_hcode', '$obs_uid'
              )
              ";
    $res = $db->insert($strSQL, false);
    if($res){

        $strSQL = "UPDATE vot2_userinfo SET info_use = '0' WHERE info_uid = '$uid'";
        $db->execute($strSQL);

        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'ลงทะเบียนบัญชีผู้ใช้งาน VOT', '$fname $lname', '$remote_ip', '$uid')
                    ";
        $db->insert($strSQL, false);

        $strSQL = "INSERT INTO vot2_userinfo (`fname`, `lname`, `phone`, `info_udatetime`, `info_use`, `info_prov`, `info_district`, `info_subdistrict`, `info_uid`) 
                   VALUES ('$fname', '$lname', '$phone', '$datetime', '1', '$tprovince', '$dist', '$subdist', '$uid')";
        $res = $db->insert($strSQL, false);
        mysqli_close($conn);
        header('Location: ../register_patient_success?uid=' . $uid . '&referal=webapp');
        die();
    }else{
        // echo $strSQL;
        die();
        ?>
        <script>
            alert('Can not create new account');
            window.history.back()
        </script>
        <?php
        $db->close();
        die();
    }
}

if($stage == 'logout'){


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

}

if($stage == 'signup'){

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
}
?>