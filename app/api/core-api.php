<?php 
require('../config/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);

$return = array();

if($stage == 'save_problem'){
    $json = file_get_contents('php://input');
    $array = json_decode($json, true);
    if(
        (!isset($array['msg'])) ||
        (!isset($array['uid']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $msg = mysqli_real_escape_string($conn, $array['msg']);
    $uid = mysqli_real_escape_string($conn, $array['uid']);

    $strSQL = "INSERT INTO vot2_problem (`prob_msg`, `prob_datetime`, `prob_uid`)
               VALUES ('$msg', '$datetime', '$uid')
              ";
    $db->insert($strSQL, false);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`) 
               VALUES ('$datetime', 'รายงานปัญหากาารใช้งาน', '$msg', '$remote_ip', '$uid')";
    $db->insert($strSQL, false);

    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'getobserver'){
    if(
        (!isset($_POST['hcod']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $hcod = mysqli_real_escape_string($conn, $_POST['hcod']);

    $strSQL = "SELECT * FROM vot2_account INNER JOIN vot2_userinfo ON vot2_account.uid = vot2_userinfo.info_uid
                WHERE hcode = '$hcod' AND info_use = '1' AND role IN ('staff', 'manager')  AND  delete_status = '0' ORDER BY fname";
    $res = $db->fetch($strSQL, true, false);

    if(($res) && ($res['status'])){
        $return['status'] = 'Success';
        $return['data'] = $res['data'];
    }else{
        $return['status'] = 'Fail (x102)'.$strSQL;
    }
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'activity_list'){
    if(
        (!isset($_GET['uid']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);

    $strSQL = "SELECT * FROM vot2_log WHERE log_uid = '$uid' ORDER BY log_datetime DESC LIMIT 100";
    $res = $db->fetch($strSQL, true, false);

    if(($res) && ($res['status'])){
        $return['status'] = 'Success';
        $return['data'] = $res['data'];
    }else{
        $return['status'] = 'Fail (x102)'.$strSQL;
    }
    echo json_encode($return);
    $db->close(); 
    die();

}

if($stage == 'check2month'){

    if(
        (!isset($_REQUEST['csdate']))
    ){
        $db->close(); die();
    }

    $csdate = mysqli_real_escape_string($conn, $_POST['csdate']);

    echo Date("Y-m-d", strtotime("$csdate +2 Month"));
    die();
}

if($stage == 'district'){
    if(
        (!isset($_REQUEST['province']))
    ){
        $db->close(); die();
    }

    $prov = mysqli_real_escape_string($conn, $_POST['province']);

    $strSQL = "SELECT * FROM vot2_ampur WHERE Changwat = '$prov'";
    $result = $db->fetch($strSQL, true, false);

    if($result['status']){
        $return['status'] = 'Success';
        $return['data'] = $result['data'];
    }

    echo json_encode($return);
    $db->close();
    die();
}

if($stage == 'subdistrict'){
    if(
        (!isset($_REQUEST['province'])) ||
        (!isset($_REQUEST['dist']))
    ){
        $db->close(); die();
    }

    $prov = mysqli_real_escape_string($conn, $_POST['province']);
    $dist = mysqli_real_escape_string($conn, $_POST['dist']);

    $strSQL = "SELECT * FROM vot2_tumbon WHERE Changwat = '$prov' AND Ampur = '$dist'";
    $result = $db->fetch($strSQL, true, false);

    if($result['status']){
        $return['status'] = 'Success';
        $return['data'] = $result['data'];
    }else{
        $return['data'] = $strSQL;
    }

    echo json_encode($return);
    $db->close();
    die();
}

if($stage == 'set_notitime'){
    $json = file_get_contents('php://input');
    $array = json_decode($json, true);
    if(
        (!isset($array['hh'])) ||
        (!isset($array['mm'])) ||
        (!isset($array['uid']))
    ){
        $return['status'] = 'Fail';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $array['uid']);
    $h = mysqli_real_escape_string($conn, $array['hh']);
    $m = mysqli_real_escape_string($conn, $array['mm']);

    if($h < 10){
        $h = '0'.$h;
    }

    if($m < 10){
        $m = '0'.$m;
    }

    $altTime = $h.':'.$m;

    $strSQL = "SELECT * FROM vot2_alerttime WHERE alt_uid = '$uid' AND alt_time = '$altTime'";
    $r = $db->fetch($strSQL, true);
    if($r){
        $return['status'] = 'Success';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $strSQL = "INSERT INTO vot2_alerttime (`alt_uid`, `alt_time`, `alt_recordtime`) VALUES ('$uid', '$altTime', '$altTime:00.000000') ";
    $db->insert($strSQL, false);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`) 
               VALUES ('$datetime', 'เพิ่มเวลาแจ้งเตือน', 'เวลา $altTime', '$remote_ip', '$uid')";
    $db->insert($strSQL, false);

    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'set_notitime2'){
    if(
        (!isset($_REQUEST['hh'])) ||
        (!isset($_REQUEST['mm'])) ||
        (!isset($_REQUEST['uid']))
    ){
        $return['status'] = 'Fail';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $h = mysqli_real_escape_string($conn, $_REQUEST['hh']);
    $m = mysqli_real_escape_string($conn, $_REQUEST['mm']);

    if($h < 10){
        $h = '0'.$h;
    }

    if($m < 10){
        $m = '0'.$m;
    }

    $altTime = $h.':'.$m;

    $strSQL = "SELECT * FROM vot2_alerttime WHERE alt_uid = '$uid' AND alt_time = '$altTime'";
    $r = $db->fetch($strSQL, true);
    if($r){
        $return['status'] = 'Success';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $strSQL = "INSERT INTO vot2_alerttime (`alt_uid`, `alt_time`, `alt_recordtime`) VALUES ('$uid', '$altTime', '$altTime:00.000000') ";
    $db->insert($strSQL, false);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`) 
               VALUES ('$datetime', 'เพิ่มเวลาแจ้งเตือน', 'เวลา $altTime', '$remote_ip', '$uid')";
    $db->insert($strSQL, false);

    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'add_new_drug'){
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['drug_name']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $drug_name = mysqli_real_escape_string($conn, $_REQUEST['drug_name']);

    $strSQL = "SELECT * FROM vot2_drug WHERE drug_name = '$uid' AND drug_status = 'Y'";
    $r = $db->fetch($strSQL, true);
    if($r){
        $return['status'] = 'Duplicate';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $strSQL = "INSERT INTO vot2_drug (`drug_name`) VALUES ('$drug_name') ";
    $r = $db->insert($strSQL, false);

    if($r){
        $return['status'] = 'Success';
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
    }

    
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'delete_new_drug'){
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['drug_id']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $drug_id = mysqli_real_escape_string($conn, $_REQUEST['drug_id']);

    $strSQL = "UPDATE vot2_drug SET drug_status = 'N' WHERE drug_id = '$drug_id'";
    $r = $db->execute($strSQL);
    if($r){
        $return['status'] = 'Success';
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
        // $return['error_msg'] = $strSQL;
    }
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'update_new_drug'){
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['dname'])) ||
        (!isset($_REQUEST['did']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $drug_id = mysqli_real_escape_string($conn, $_REQUEST['did']);
    $dname = mysqli_real_escape_string($conn, $_REQUEST['dname']);

    $strSQL = "SELECT * FROM vot2_drug WHERE drug_name = '$dname' AND drug_status = 'Y' AND drug_id != '$drug_id'";
    $res = $db->fetch($strSQL, false);
    if($res){
        $return['status'] = 'Duplicate';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $strSQL = "UPDATE vot2_drug SET drug_name = '$dname' WHERE drug_id = '$drug_id'";
    $r = $db->execute($strSQL);
    if($r){
        $return['status'] = 'Success';
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
    }
    echo json_encode($return);
    $db->close(); 
    die();
}

