<?php 
session_start();
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);

if($stage == 'add_hcode'){

    if(
        (!isset($_REQUEST['target_hcode']))
    ){
        $db->close(); die();
    }

    $hcode = mysqli_real_escape_string($conn, $_POST['target_hcode']);

    $strSQL = "SELECT * FROM vot2_projecthospital WHERE phoscode = '$hcode'";
    $result = $db->fetch($strSQL, false);
    if($result){
        $strSQL = "UPDATE vot2_projecthospital SET phosstatus = 'Y' WHERE phoscode = '$hcode'";
        $r2 = $db->execute($strSQL);
        echo "Success";
        $db->close();
        die();
    }

    $strSQL = "INSERT INTO vot2_projecthospital (`phoscode`, `phosstatus`, `hserv`, `hlat`, `hlng`, `hamp`, `htum`, `hosname`, `htype_code`) 
               VALUE ('$hcode', '$hcode', '$hcode', '$hcode', '$hcode', '$hcode', '$hcode', '$hcode', '$hcode')";
    $result = $db->insert($strSQL, false);
    if($result){

        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
               VALUES ('$datetime', 'เพิ่มสถานบริการในการติดตาม', 'Target HCODE > $hcode', '$remote_ip', '".$_SESSION['thvot_uid']."')
              ";
        $db->insert($strSQL, false);

        echo "Success";
        $db->close();
        die();
    }
}

if($stage == 'remove_hcode'){

    if(
        (!isset($_REQUEST['target_hcode']))
    ){
        $db->close(); die();
    }

    $hcode = mysqli_real_escape_string($conn, $_POST['target_hcode']);

    $strSQL = "DELETE FROM vot2_projecthospital WHERE phoscode = '$hcode'";
    $result = $db->execute($strSQL);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
               VALUES ('$datetime', 'ลบสถานบริการในการติดตาม', 'Target HCODE > $hcode', '$remote_ip', '".$_SESSION['thvot_uid']."')
              ";
    $db->insert($strSQL, false);

    echo "Success";
    $db->close();
    die();    

}

if($stage == 'admin_delete_user'){
    if(
        (!isset($_REQUEST['target_uid']))
    ){
        $db->close(); die();
    }

    $target_uid = mysqli_real_escape_string($conn, $_POST['target_uid']);

    $strSQL = "UPDATE vot2_account SET delete_status = '1' WHERE uid = '$target_uid'";
    $result = $db->execute($strSQL);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
               VALUES ('$datetime', 'ลบบัญชีผู้ใช้งาน', 'Target UID > $target_uid', '$remote_ip', '".$_SESSION['thvot_uid']."')
              ";
    $db->insert($strSQL, false);

    echo "Success";
    $db->close();
    die();    
}

if($stage == 'toggle_active'){
    if(
        (!isset($_REQUEST['target_id'])) ||
        (!isset($_REQUEST['toggle_to']))
    ){
        $db->close(); die();
    }

    $target_uid = mysqli_real_escape_string($conn, $_POST['target_id']);
    $toggle_to = mysqli_real_escape_string($conn, $_POST['toggle_to']);

    $strSQL = "UPDATE vot2_account SET verify_status = '$toggle_to' WHERE ID = '$target_uid'";
    $result = $db->execute($strSQL);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                       VALUES ('$datetime', 'เปลี่ยนสถานะการยืนยัน (Verify status) เป็น $toggle_to', 'Target UID > $target_uid ', '$remote_ip', '".$_SESSION['thvot_uid']."')
                      ";
    $db->insert($strSQL, false);

    echo "Success";
    $db->close();
    die();   
}

if($stage == 'toggle_status'){
    if(
        (!isset($_REQUEST['target_id'])) ||
        (!isset($_REQUEST['toggle_to']))
    ){
        $db->close(); die();
    }

    $target_uid = mysqli_real_escape_string($conn, $_POST['target_id']);
    $toggle_to = mysqli_real_escape_string($conn, $_POST['toggle_to']);

    $strSQL = "UPDATE vot2_account SET active_status = '$toggle_to' WHERE ID = '$target_uid'";
    $result = $db->execute($strSQL);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                       VALUES ('$datetime', 'เปลี่ยนสถานะการใช้งาน (Active status) เป็น $toggle_to', 'Target UID > $target_uid', '$remote_ip', '".$_SESSION['thvot_uid']."')
                      ";
    $db->insert($strSQL, false);

    echo "Success";
    $db->close();
    die();   
}

if($stage == 'toggle_access'){
    if(
        (!isset($_REQUEST['target_id'])) ||
        (!isset($_REQUEST['toggle_to'])) ||
        (!isset($_REQUEST['level']))
    ){
        $db->close(); die();
    }

    $target_uid = mysqli_real_escape_string($conn, $_POST['target_id']);
    $toggle_to = mysqli_real_escape_string($conn, $_POST['toggle_to']);
    $level = mysqli_real_escape_string($conn, $_POST['level']);

    $strSQL = "UPDATE vot2_account SET ".$level." = '$toggle_to' WHERE ID = '$target_uid'";
    $result = $db->execute($strSQL);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
               VALUES ('$datetime', 'เปลี่ยนระดับการเข้าถึงข้อมูล ($level) เป็น $toggle_to', 'Target UID > $target_uid', '$remote_ip', '".$_SESSION['thvot_uid']."')
              ";
    $db->insert($strSQL, false);

    echo "Success";
    $db->close();
    die();   


}

if($stage == 'admin_reset_patient_location'){
    if(
        (!isset($_REQUEST['target_uid']))
    ){
        $db->close(); die();
    }

    $target_uid = mysqli_real_escape_string($conn, $_POST['target_uid']);

    $strSQL = "UPDATE vot2_patient_location SET loc_status = '0' WHERE loc_patient_uid = '$target_uid'";
    $res = $db->execute($strSQL);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                       VALUES ('$datetime', 'รีเซ็ตพิกัดผู้ป่วย', 'Target UID > $target_uid', '$remote_ip', '".$_SESSION['thvot_uid']."')
                      ";
    $db->insert($strSQL, false);

    echo "Success";
    $db->close();
    die();   
}

if($stage == 'checkuser'){
    if(
        (!isset($_REQUEST['username'])) ||
        (!isset($_REQUEST['role'])) ||
        (!isset($_REQUEST['hcode']))
    ){
        $db->close(); die();
    }

    $username = mysqli_real_escape_string($conn, $_REQUEST['username']);
    $role = mysqli_real_escape_string($conn, $_REQUEST['role']);
    $hcode = mysqli_real_escape_string($conn, $_REQUEST['hcode']);

    $strSQL = "SELECT * FROM vot2_account WHERE username = '$username' AND delete_status = '0' LIMIT 1";
    $res = $db->fetch($strSQL, true, true);
    if(($res) && ($res['status']) && ($res['count'] > 0)){
        echo $strSQL;
        echo "Duplicate";
    }else{
        echo "Success";
    }
    $db->close();
    die();   
}



?>