<?php 
// session_start();
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);

if($stage == 'create'){
    if(
        (!(isset($_POST['txtUsername']))) ||
        (!(isset($_POST['txtFname']))) ||
        (!(isset($_POST['txtLname']))) ||
        (!(isset($_POST['txtPhone']))) ||
        (!(isset($_POST['txtRole']))) ||
        (!(isset($_POST['txtStatus']))) ||
        (!(isset($_POST['txtVerify']))) || 
        (!(isset($_POST['txtHcode'])))
    ){
        ?>
        <script>
            alert('Can not create new account');
            window.history.back()
        </script>
        <?php
        $db->close();
        die();
    }
    $prefix = mysqli_real_escape_string($conn, $_POST['txtPrefix']);
    $username = mysqli_real_escape_string($conn, $_POST['txtUsername']);
    $fname = mysqli_real_escape_string($conn, $_POST['txtFname']);
    $lname = mysqli_real_escape_string($conn, $_POST['txtLname']);
    $phone = mysqli_real_escape_string($conn, $_POST['txtPhone']);
    $email = mysqli_real_escape_string($conn, $_POST['txtEmail']);
    $role = mysqli_real_escape_string($conn, $_POST['txtRole']);
    $status = mysqli_real_escape_string($conn, $_POST['txtStatus']);
    $verify = mysqli_real_escape_string($conn, $_POST['txtVerify']);
    $hcode = mysqli_real_escape_string($conn, $_POST['txtHcode']);
    $password = mysqli_real_escape_string($conn, $_POST['txtPassword1']);

    if($role == 'patient'){
        $username = $prefix."-".$username;
    }

    $strSQL = "SELECT * FROM vot2_account WHERE username = '$username' AND delete_status = '0' LIMIT 1";
    $res1 = $db->fetch($strSQL, true, true);
    if(($res1['status']) && ($res1['count'] > 0)){
        ?>
        <script>
            alert('Duplicate username');
            window.history.back()
        </script>
        <?php
        $db->close();
        die();
    }

    $passwordlen = strlen($password);
    $patient_type = 'NA';
    if($role == 'patient'){
        $patient_type = 'VOT';
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $uid = base64_encode($dateuniversal.$hcode);

    $strSQL = "INSERT INTO vot2_account 
              (`uid`, `username`, `password`, `password_len`, `email`, 
              `phone`, `role`, `patient_type`, `hcode`, 
              `verify_status`, `active_status`, `u_datetime`, `p_udatetime`)
              VALUES (
                  '$uid', '$username', '$password', '$passwordlen', '$email', 
                  '$phone', '$role', '$patient_type', '$hcode',
                  '$verify', '$status', '$datetime', '$datetime'
              )
              ";
    $res = $db->insert($strSQL, false);
    if($res){

        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'สร้างบัญชีผู้ใช้งาน', '$fname $lname', '$remote_ip', '".$_SESSION['thvot_uid']."')
                    ";
        $db->insert($strSQL, false);

        $strSQL = "INSERT INTO vot2_userinfo (`fname`, `lname`, `phone`, `info_udatetime`, `info_use`, `info_uid`) 
                   VALUES ('$fname', '$lname', '$phone', '$datetime', '1', '$uid')";
        $res = $db->insert($strSQL, false);

        // echo $strSQL;
        // die();

        header('Location: ../core/'.$_SESSION['thvot_role'].'/system/app-users-list');
        $db->close();
        die();
    }else{
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

if($stage == 'updateinfo'){
    if(
        (!(isset($_POST['txtUsername']))) ||
        (!(isset($_POST['txtFname']))) ||
        (!(isset($_POST['txtLname']))) ||
        (!(isset($_POST['txtPhone']))) ||
        (!(isset($_POST['txtRole']))) ||
        (!(isset($_POST['txtStatus']))) ||
        (!(isset($_POST['txtVerify']))) || 
        (!(isset($_POST['txtHcode'])))
    ){
        ?>
        <script>
            alert('Can not create new account');
            window.history.back()
        </script>
        <?php
        $db->close();
        die();
    }
    $prefix = mysqli_real_escape_string($conn, $_POST['txtPrefix']);
    $username = mysqli_real_escape_string($conn, $_POST['txtUsername']);
    $fname = mysqli_real_escape_string($conn, $_POST['txtFname']);
    $lname = mysqli_real_escape_string($conn, $_POST['txtLname']);
    $phone = mysqli_real_escape_string($conn, $_POST['txtPhone']);
    $email = mysqli_real_escape_string($conn, $_POST['txtEmail']);
    $role = mysqli_real_escape_string($conn, $_POST['txtRole']);
    $status = mysqli_real_escape_string($conn, $_POST['txtStatus']);
    $verify = mysqli_real_escape_string($conn, $_POST['txtVerify']);
    $hcode = mysqli_real_escape_string($conn, $_POST['txtHcode']);

    

    $strSQL = "SELECT uid FROM vot2_account WHERE username = '$username'";
    $result = $db->fetch($strSQL, false);
    if($result){
        $strSQL = "UPDATE vot2_account 
              SET 
              role = '$role',
              hcode = '$hcode',
              verify_status = '$verify',
              active_status = '$status',
              u_datetime = '$datetime'
              WHERE username = '$username'
              ";
        $res = $db->execute($strSQL);

        $uid = $result['uid'];

        $strSQL = "UPDATE vot2_userinfo SET info_use = '0' WHERE info_uid = '$uid'";
        $res = $db->execute($strSQL);

        $strSQL = "INSERT INTO vot2_userinfo (`fname`, `lname`, `phone`, `info_udatetime`, `info_use`, `info_uid`) 
                   VALUES ('$fname', '$lname', '$phone', '$datetime', '1', '$uid')";
        $res = $db->insert($strSQL, false);

        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'ปรับปรุงข้อมูลผู้ใช้งาน', 'Target UID -> $uid', '$remote_ip', '".$_SESSION['thvot_uid']."')
                    ";
        $db->insert($strSQL, false);


    }

    
    header('Location: ../core/'.$_SESSION['thvot_role'].'/system/app-users-list');
    $db->close();
    die();

    
}

if($stage == 'updatemonitor'){
    if(
        (!(isset($_POST['txtMonitorUid']))) ||
        (!(isset($_POST['txtStartmonitor']))) ||
        (!(isset($_POST['txtEndmonitor'])))
    ){
        $db->close();
        die();
        ?>
        <script>
            alert('Can not set monitor date');
            window.history.back()
        </script>
        <?php
    }

    $uid = mysqli_real_escape_string($conn, $_POST['txtMonitorUid']);
    $start = mysqli_real_escape_string($conn, $_POST['txtStartmonitor']);
    $end = mysqli_real_escape_string($conn, $_POST['txtEndmonitor']);

    $strSQL = "UPDATE vot2_account SET start_obsdate = '$start', end_obsdate = '$end' WHERE uid = '$uid'";
    $db->execute($strSQL);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'ปรับปรุงวันที่เริ่มและสิ้นสุดการติดตาม', 'Target UID > $uid', '$remote_ip', '".$_SESSION['thvot_uid']."')
                    ";
    $db->insert($strSQL, false);

    ?>
    <script>
        alert('ปรับปรุงวันที่ติดตามสำเร็จ');
        window.history.back()
    </script>
    <?php
    $db->close();
    die();

}

if($stage == 'updatepassword'){
    if(
        (!(isset($_POST['txtPasswordUid']))) ||
        (!(isset($_POST['txtPassword1'])))
    ){
        $db->close();
        die();
        ?>
        <script>
            alert('Can not create new account');
            window.history.back()
        </script>
        <?php
       
    }
    $uid = mysqli_real_escape_string($conn, $_POST['txtPasswordUid']);
    $password = mysqli_real_escape_string($conn, $_POST['txtPassword1']);

    $passwordlen = strlen($password);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $strSQL = "UPDATE vot2_account SET password = '$password', password_len = '$passwordlen' WHERE uid = '$uid'";
    $db->execute($strSQL);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'ปรับปรุงรหัสผ่าน', 'Target UID > $uid', '$remote_ip', '".$_SESSION['thvot_uid']."')
                    ";
    $db->insert($strSQL, false);

    ?>
    <script>
        alert('ปรับปรุงรหัสผ่านสำเร็จ');
        window.history.back()
    </script>
    <?php
    $db->close();
    die();
}

if($stage == 'create_patient'){
    if(
        (!(isset($_POST['txtUsername']))) ||
        (!(isset($_POST['txtFname']))) ||
        (!(isset($_POST['txtLname']))) ||
        (!(isset($_POST['txtPhone']))) ||
        (!(isset($_POST['txtRole']))) ||
        (!(isset($_POST['txtStatus']))) ||
        (!(isset($_POST['txtVerify']))) || 
        (!(isset($_POST['txtHcode'])))
    ){
        ?>
        <script>
            alert('Can not create new account');
            window.history.back()
        </script>
        <?php
        $db->close();
        die();
    }
    $prefix = mysqli_real_escape_string($conn, $_POST['txtPrefix']);
    $username = mysqli_real_escape_string($conn, $_POST['txtUsername']);
    $fname = mysqli_real_escape_string($conn, $_POST['txtFname']);
    $lname = mysqli_real_escape_string($conn, $_POST['txtLname']);
    $phone = mysqli_real_escape_string($conn, $_POST['txtPhone']);
    $role = mysqli_real_escape_string($conn, $_POST['txtRole']);
    $status = mysqli_real_escape_string($conn, $_POST['txtStatus']);
    $verify = mysqli_real_escape_string($conn, $_POST['txtVerify']);
    $hcode = mysqli_real_escape_string($conn, $_POST['txtHcode']);
    $password = mysqli_real_escape_string($conn, $_POST['txtPassword1']);

    $hn = mysqli_real_escape_string($conn, $_POST['txtHn']);
    $prov = mysqli_real_escape_string($conn, $_POST['txtProvince']);
    $dist = mysqli_real_escape_string($conn, $_POST['txtDist']);
    $subdist = mysqli_real_escape_string($conn, $_POST['txtSubdist']);

    // $username = $username;

    $strSQL = "SELECT * FROM vot2_account WHERE username = '$username' AND delete_status = '0' LIMIT 1";
    $res1 = $db->fetch($strSQL, true, true);
    if(($res1['status']) && ($res1['count'] > 0)){
        ?>
        <script>
            alert('Duplicate username');
            window.history.back()
        </script>
        <?php
        $db->close();
        die();
    }

    $passwordlen = strlen($password);
    $patient_type = 'NA';

    $password = password_hash($password, PASSWORD_DEFAULT);
    $uid = base64_encode($dateuniversal.$hcode);


    $endmondate = Date("Y-m-d", strtotime("$date +4 Month"));    

    $strSQL = "INSERT INTO vot2_account 
              (`uid`, `hn`,  `username`, `password`, `password_len`, 
              `phone`, `role`, `patient_type`, `hcode`, 
              `verify_status`, `active_status`, `u_datetime`, `p_udatetime`, `start_obsdate`, `end_obsdate`)
              VALUES (
                  '$uid', '$hn', '$username', '$password', '$passwordlen', 
                  '$phone', 'patient', '$role', '$hcode',
                  '$verify', '$status', '$datetime', '$datetime', '$date', '$endmondate'
              )
              ";
    $res = $db->insert($strSQL, false);
    if($res){

        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'สร้างบัญชีผู้ใช้งานสำหรับผู้ป่วย', '$fname $lname', '$remote_ip', '".$_SESSION['thvot_uid']."')
                    ";
        $db->insert($strSQL, false);

        // $strSQL = "INSERT INTO vot2_userinfo (`fname`, `lname`, `phone`, `info_udatetime`, `info_use`, `info_uid`) 
        //            VALUES ('$fname', '$lname', '$phone', '$datetime', '1', '$uid')";
        // $res = $db->insert($strSQL, false);

        $strSQL = "INSERT INTO vot2_userinfo (`fname`, `lname`, `phone`, `info_udatetime`, `info_use`, `info_prov`, `info_district`, `info_subdistrict`, `info_uid`) 
        VALUES ('$fname', '$lname', '$phone', '$datetime', '1', '$prov', '$dist', '$subdist', '$uid')";

        header('Location: ../core/'.$_SESSION['thvot_role'].'/system/app-patient-edit?id='.$uid);
        $db->close();
        die();
    }else{
        ?>
        <script>
            alert('Can not create new patient account');
            window.history.back()
        </script>
        <?php
        $db->close();
        die();
    }
}

if($stage == 'update_patient'){
    if(
        (!(isset($_POST['txtUid']))) ||
        (!(isset($_POST['txtFname']))) ||
        (!(isset($_POST['txtLname']))) ||
        (!(isset($_POST['txtPhone']))) ||
        (!(isset($_POST['txtRole']))) ||
        (!(isset($_POST['txtStatus']))) ||
        (!(isset($_POST['txtVerify']))) || 
        (!(isset($_POST['txtHcode'])))
    ){
        ?>
        <script>
            alert('Can not create new accountx');
            window.history.back()
        </script>
        <?php
        $db->close();
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_POST['txtUid']);
    $username = mysqli_real_escape_string($conn, $_POST['txtUsername']);
    $fname = mysqli_real_escape_string($conn, $_POST['txtFname']);
    $lname = mysqli_real_escape_string($conn, $_POST['txtLname']);
    $phone = mysqli_real_escape_string($conn, $_POST['txtPhone']);
    $role = mysqli_real_escape_string($conn, $_POST['txtRole']);
    $status = mysqli_real_escape_string($conn, $_POST['txtStatus']);
    $verify = mysqli_real_escape_string($conn, $_POST['txtVerify']);
    $hcode = mysqli_real_escape_string($conn, $_POST['txtHcode']);

    $strSQL = "SELECT * FROM vot2_account WHERE uid = '$uid' AND delete_status = '0' LIMIT 1";
    $res1 = $db->fetch($strSQL, true, true);
    if(!$res1['status']){
        ?>
        <script>
            alert('Patient not found');
            window.history.back()
        </script>
        <?php
        $db->close();
        die();
    }

    $strSQL = "UPDATE vot2_account 
               SET 
               phone = '$phone', 
               patient_type = '$role', 
               verify_status = '$verify', 
               active_status = '$status', 
               u_datetime = '$datetime',
               hcode = '$hcode'
               WHERE 
               uid = '$uid'
               ";

    $res = $db->execute($strSQL);
    if($res){
        $strSQL = "UPDATE vot2_userinfo SET info_use = '0' WHERE info_uid = '$uid'";
        $db->execute($strSQL);

        $strSQL = "INSERT INTO vot2_userinfo (`fname`, `lname`, `phone`, `info_udatetime`, `info_use`, `info_uid`) 
                   VALUES ('$fname', '$lname', '$phone', '$datetime', '1', '$uid')";
        $res = $db->insert($strSQL, false);

        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'ปรับปรุงข้อมูลผู้ป่วย', '$fname $lname ($uid)', '$remote_ip', '".$_SESSION['thvot_uid']."')
                    ";
        $db->insert($strSQL, false);

        // header('Location: ../core/'.$_SESSION['thvot_role'].'/system/app-patient-edit?id='.$uid);
        $db->close();

        ?>
        <script>
            alert('Update patient info success');
            window.history.back()
        </script>
        <?php
        $db->close();
        die();

        die();
    }else{
        echo $strSQL;
        die();
        ?>
        <script>
            alert('Can not update patient information');
            window.history.back()
        </script>
        <?php
        $db->close();
        die();
    }
}