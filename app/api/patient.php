<?php 
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);
$return = array();

if($stage == 'listofpatientstaff'){
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


    $strSQL = "SELECT a.uid, a.username, a.profile_img, b.fname, b.lname, a.hcode, c.hosname , a.patient_type
                FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                INNER JOIN vot2_chospital c ON a.hcode = c.hoscode 
                WHERE 
                a.obs_hcode = '$hcode' 
                AND b.info_use = '1' 
                AND a.delete_status = '0' 
                AND a.role = 'patient'
                AND a.active_status = '1'
                AND a.verify_status = '1'
                AND a.obs_uid = '$uid'
                LIMIT $page, $limit";
    $res = $db->fetch($strSQL,true,false);
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

if($stage == 'numofpatientstaff'){
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


    $strSQL = "SELECT a.uid
                FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                INNER JOIN vot2_chospital c ON a.hcode = c.hoscode 
                WHERE 
                a.obs_hcode = '$hcode' 
                AND b.info_use = '1' 
                AND a.delete_status = '0' 
                AND a.role = 'patient'
                AND a.active_status = '1'
                AND a.verify_status = '1'
                AND a.obs_uid = '$uid'";
    $res = $db->fetch($strSQL, true, true);
    if(($res) && ($res['status'])){
        $return['status'] = 'Success';
        $return['data']['record'] = $res['count'];
    }else{
        // $return['status'] = 'Fail (x102)'.$strSQL;
        $return['status'] = 'Success';
        $return['data']['record'] = 0;
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
    // $page = $page - 1;
    // if($page != 1){
    //     $page = ($page - 1) * $limit;
    // }

    $page = ($page * $limit) - $limit;

    // if($page < 0){ $page = 0; }

    $strSQL = "SELECT role FROM vot2_account WHERE uid = '$uid'";
    $res1 = $db->fetch($strSQL, false);
    if($res1){
        $role = $res1['role'];
        if($role == 'manager'){
            $strSQL = "SELECT a.uid, a.username, a.profile_img, b.fname, b.lname, a.hcode, c.hosname , a.patient_type
                       FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                       INNER JOIN vot2_chospital c ON a.hcode = c.hoscode 
                       WHERE a.hcode IN (
                           SELECT phoscode FROM vot2_projecthospital WHERE hospcode = '$hcode'
                       )
                       AND b.info_use = '1' 
                       AND a.delete_status = '0' 
                       AND a.role = 'patient'
                       AND a.active_status = '1'
                       AND a.verify_status = '1'
                       LIMIT $page, $limit";
            $res = $db->fetch($strSQL,true,false);
            if(($res) && ($res['status'])){
                $return['status'] = 'Success';
                $return['data'] = $res['data'];
            }else{
                $return['status'] = 'Fail (x102)';
            }
        }else if($role == 'staff'){
            $strSQL = "SELECT a.uid, a.username, a.profile_img, b.fname, b.lname, a.hcode, c.hosname , a.patient_type
                       FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
                       INNER JOIN vot2_chospital c ON a.hcode = c.hoscode 
                       WHERE 
                       a.hcode = '$hcode' 
                       AND b.info_use = '1' 
                       AND a.delete_status = '0' 
                       AND a.role = 'patient'
                       AND a.active_status = '1'
                       AND a.verify_status = '1'
                       LIMIT $page, $limit";
            $res = $db->fetch($strSQL,true,false);
            if(($res) && ($res['status'])){
                $return['status'] = 'Success';
                $return['data'] = $res['data'];
            }else{
                $return['status'] = 'Fail (x102)';
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
            $strSQL = "SELECT a.uid, a.username, a.profile_img, b.fname, b.lname, a.hcode, c.hosname , a.patient_type
            FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
            INNER JOIN vot2_chospital c ON a.hcode = c.hoscode 
            WHERE 
            b.info_use = '1' 
            AND a.delete_status = '0' 
            AND a.role = 'patient'
            AND a.active_status = '1'
            AND a.verify_status = '1'
            LIMIT $page, $limit";
            $res = $db->fetch($strSQL,true,false);
            if(($res) && ($res['status'])){
                $return['status'] = 'Success';
                $return['data'] = $res['data'];
            }else{
                $return['status'] = 'Fail (x102)';
            }
        }
    }

    
    
    echo json_encode($return);
    $db->close(); 
    die();

}

if($stage == 'patient_info'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['patient_id']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $patient_id = mysqli_real_escape_string($conn, $_GET['patient_id']);

    $strSQL = "SELECT a.*, b.*, a.ID user_id, c.hosname, d.*
               FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid 
               INNER JOIN vot2_chospital c ON a.hcode = c.hoscode
               LEFT JOIN vot2_patient_location d ON a.uid = d.loc_patient_uid
               WHERE a.username = '$patient_id' 
               AND a.delete_status = '0' 
               AND b.info_use = '1'
               AND (d.loc_status = '1' OR d.loc_status IS NULL)
               LIMIT 1";
    $selected_user = $db->fetch($strSQL, false);
    if(!$selected_user){
        $return['status'] = 'Fail (x102)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $return['status'] = 'Success';

    $selected_user['location_status_c'] = '';
    if($selected_user['location_status'] == 1){
        $selected_user['location_status_c'] = 'checked';
    }

    $selected_user['limg_status_c'] = '';
    if($selected_user['profile_status'] == 1){
        $selected_user['limg_status_c'] = 'checked';
    }

    $selected_user['active_status_c'] = '';
    if($selected_user['active_status'] == 1){
        $selected_user['active_status_c'] = 'checked';
    }

    $return['data'] = $selected_user;
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'patient_location'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['patient_id']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $patient_id = mysqli_real_escape_string($conn, $_GET['patient_id']);


    $strSQL = "SELECT * FROM vot2_patient_location WHERE loc_patient_uid = '$patient_id' AND loc_status = '1'";
    $selected_location = $db->fetch($strSQL, false);

    if(!$selected_location){
        $return['status'] = 'Fail (x102)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $return['status'] = 'Success';
    $return['data'] = $selected_location;
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'patient_stage'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['patient_id'])) ||
        (!isset($_GET['var']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $patient_id = mysqli_real_escape_string($conn, $_GET['patient_id']);
    $var = mysqli_real_escape_string($conn, $_GET['var']);

    if($var == 'location'){
        $strSQL = "SELECT location_status FROM vot2_account WHERE username = '$patient_id' AND delete_status = '0'";
        $res = $db->fetch($strSQL, false);
        if($res){
            $c = $res['location_status'];
            $ts = '1';
            if($c == '1'){
                $ts = '0';
            }

            $strSQL = "UPDATE vot2_account SET location_status = '$ts' WHERE  username = '$patient_id' AND delete_status = '0'";
            $db->execute($strSQL);
        }
    }

    if($var == 'active'){
        $strSQL = "SELECT active_status FROM vot2_account WHERE username = '$patient_id' AND delete_status = '0'";
        $res = $db->fetch($strSQL, false);
        if($res){
            $c = $res['active_status'];
            $ts = '1';
            if($c == '1'){
                $ts = '0';
            }

            $strSQL = "UPDATE vot2_account SET active_status = '$ts' WHERE  username = '$patient_id' AND delete_status = '0'";
            $db->execute($strSQL);
        }
    }

    if($var == 'img'){
        $strSQL = "SELECT profile_status FROM vot2_account WHERE username = '$patient_id' AND delete_status = '0'";
        $res = $db->fetch($strSQL, false);
        if($res){
            $c = $res['profile_status'];
            $ts = '1';
            if($c == '1'){
                $ts = '0';
            }

            $strSQL = "UPDATE vot2_account SET profile_status = '$ts' WHERE  username = '$patient_id' AND delete_status = '0'";
            $db->execute($strSQL);
        }
    }

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
        VALUES ('$datetime', 'ปรับปรุงสถานะ ($var)', 'Target TB NO : $patient_id', '$remote_ip', '$uid')
    ";
    $db->insert($strSQL, false);

    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die();
    
}

if($stage == 'patient_update_info'){
    if(
        (!(isset($_POST['puid']))) ||
        (!(isset($_POST['pusername']))) ||
        (!(isset($_POST['fname']))) ||
        (!(isset($_POST['lname']))) ||
        (!(isset($_POST['phone']))) ||
        (!(isset($_POST['status']))) ||
        (!(isset($_POST['verify']))) || 
        (!(isset($_POST['province']))) ||
        (!(isset($_POST['district']))) ||
        (!(isset($_POST['subdistrict']))) ||
        (!(isset($_POST['uid'])))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $puid = mysqli_real_escape_string($conn, $_POST['puid']);
    $username = mysqli_real_escape_string($conn, $_POST['pusername']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $verify = mysqli_real_escape_string($conn, $_POST['verify']);
    $reg_hcode = mysqli_real_escape_string($conn, $_POST['reg_hcode']);
    $manage_hcode = mysqli_real_escape_string($conn, $_POST['hcode']);
    $obs_hcode = mysqli_real_escape_string($conn, $_POST['obs_hcode']);
    $ptype = mysqli_real_escape_string($conn, $_POST['ptype']);

    $province = mysqli_real_escape_string($conn, $_POST['province']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $subdistrict = mysqli_real_escape_string($conn, $_POST['subdistrict']);

    $strSQL = "SELECT * FROM vot2_account WHERE uid = '$uid' AND delete_status = '0' LIMIT 1";
    $res1 = $db->fetch($strSQL, true, true);
    if(!$res1['status']){
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $strSQL = "SELECT * FROM vot2_account WHERE uid = '$puid' AND delete_status = '0' LIMIT 1";
    $res1 = $db->fetch($strSQL, true, true);
    if(!$res1['status']){
        $return['status'] = 'Fail';
        $return['error_stage'] = '3';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $strSQL = "UPDATE vot2_account 
               SET 
               phone = '$phone', 
               patient_type = '$ptype', 
               verify_status = '$verify', 
               active_status = '$status', 
               u_datetime = '$datetime',
               hcode = '$manage_hcode',
               reg_hcode = '$reg_hcode',
               hcode = '$manage_hcode',
               obs_hcode = '$obs_hcode'
               WHERE 
               uid = '$puid'
               ";

    $res = $db->execute($strSQL);
    if($res){
        $strSQL = "UPDATE vot2_userinfo SET info_use = '0' WHERE info_uid = '$puid'";
        $db->execute($strSQL);

        $strSQL = "INSERT INTO vot2_userinfo (`fname`, `lname`, `phone`, `info_prov`, `info_district`, `info_subdistrict`, `info_udatetime`, `info_use`, `info_uid`) 
                   VALUES ('$fname', '$lname', '$phone', '$province', '$district', '$subdistrict', '$datetime', '1', '$puid')";
        $res = $db->insert($strSQL, false);

        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'ปรับปรุงข้อมูลผู้ป่วย', '$fname $lname ($puid)', '$remote_ip', '$uid')
                    ";
        $db->insert($strSQL, false);
        $return['status'] = 'Success';
        echo json_encode($return);
        $db->close(); 
        die();
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '4';
        echo json_encode($return);
        $db->close(); 
        die();
    }
}

if($stage == 'updatepassword'){
    if(
        (!(isset($_REQUEST['uid']))) ||
        (!(isset($_REQUEST['puid']))) ||
        (!(isset($_REQUEST['password'])))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }
    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $puid = mysqli_real_escape_string($conn, $_POST['puid']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $passwordlen = strlen($password);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $strSQL = "UPDATE vot2_account SET password = '$password', password_len = '$passwordlen' WHERE uid = '$puid'";
    $db->execute($strSQL);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
                    VALUES ('$datetime', 'ปรับปรุงรหัสผ่าน', 'Target UID > $puid', '$remote_ip', '$uid')
                    ";
    $db->insert($strSQL, false);

    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'add_drug'){
    if(
        (!(isset($_REQUEST['puid']))) ||
        (!(isset($_REQUEST['uid']))) ||
        (!(isset($_REQUEST['drug_id']))) ||
        (!(isset($_REQUEST['drug_name']))) ||
        (!(isset($_REQUEST['drug_q'])))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $puid = mysqli_real_escape_string($conn, $_REQUEST['puid']);
    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $drug_id = mysqli_real_escape_string($conn, $_REQUEST['drug_id']);
    $drug_name_other = mysqli_real_escape_string($conn, $_REQUEST['drug_name']);
    $drug_q = mysqli_real_escape_string($conn, $_REQUEST['drug_q']);
    $drug_info = mysqli_real_escape_string($conn, $_REQUEST['drug_info']);

    $strSQL = "SELECT * FROM vot2_patient_med WHERE med_pid = '$puid' AND med_id = '$drug_id' AND med_status = 'Y'";
    $res = $db->fetch($strSQL, true, true);
    if(($res) && ($res['count'] > 0)){
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    if($drug_id == '99'){
        $strSQL = "SELECT username FROM vot2_account WHERE uid = '$puid' LIMIT 1";
        $resU = $db->fetch($strSQL, false);

        $pusername = $resU['username'];

        $strSQL = "INSERT INTO vot2_patient_med (`med_pid`, `med_username`, `med_id`, `med_name`, `med_amount`, `med_mg`, `med_desc`, `med_status`, `med_udatetime`)
                VALUES ('$puid ', '$pusername', '$drug_id', '$drug_name_other', '$drug_q', '', '$drug_info', 'Y', '$datetime')";
        $resInsert = $db->insert($strSQL, false);
        if($resInsert){

            $strSQL = "UPDATE vot2_med_transaction SET mt_status = 'N' WHERE mt_patient_uid = '$puid'";
            $res2 = $db->execute($strSQL);

            $return['status'] = 'Success';
            echo json_encode($return);
            $db->close(); 
            die();
        }else{
            $return['status'] = 'Fail';
            $return['error_stage'] = '4';
            echo json_encode($return);
            $db->close(); 
            die();
        }

    }else{
        $strSQL = "SELECT * FROM vot2_drug WHERE drug_id = '$drug_id' AND drug_status = 'Y' LIMIT 1";
        $res = $db->fetch($strSQL, false);
        if($res){

            $strSQL = "SELECT username FROM vot2_account WHERE uid = '$puid' LIMIT 1";
            $resU = $db->fetch($strSQL, false);

            $pusername = $resU['username'];

            $dname = $res['drug_name'];
            $strSQL = "INSERT INTO vot2_patient_med (`med_pid`, `med_username`, `med_id`, `med_name`, `med_amount`, `med_mg`, `med_desc`, `med_status`, `med_udatetime`)
                    VALUES ('$puid ', '$pusername', '$drug_id', '$dname', '$drug_q', '', '$drug_info', 'Y', '$datetime')";
            $resInsert = $db->insert($strSQL, false);
            if($resInsert){

                $strSQL = "UPDATE vot2_med_transaction SET mt_status = 'N' WHERE mt_patient_uid = '$puid'";
                $res2 = $db->execute($strSQL);

                $return['status'] = 'Success';
                echo json_encode($return);
                $db->close(); 
                die();
            }else{
                $return['status'] = 'Fail';
                $return['error_stage'] = '4';
                echo json_encode($return);
                $db->close(); 
                die();
            }

        }else{
            $return['status'] = 'Fail';
            $return['error_stage'] = '3';
            echo json_encode($return);
            $db->close(); 
            die();
        }
    }

    
}

if($stage == 'list_patient_drug'){
    if(
        (!(isset($_REQUEST['puid']))) ||
        (!(isset($_REQUEST['uid'])))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $puid = mysqli_real_escape_string($conn, $_REQUEST['puid']);
    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);

    $strSQL = "SELECT * FROM vot2_patient_med WHERE med_pid = '$puid' AND med_delete = 'N' AND med_status = 'Y' ORDER BY med_name";
    $res = $db->fetch($strSQL, true, true);
    if(($res) && ($res['count'] > 0)){
        $return['status'] = 'Success';
        $return['data'] = $res['data'];
        echo json_encode($return);
        $db->close(); 
        die();
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
        echo json_encode($return);
        $db->close(); 
        die();
    }
}

if($stage == 'get_patient_drug'){
    if(
        (!(isset($_REQUEST['did']))) ||
        (!(isset($_REQUEST['puid']))) ||
        (!(isset($_REQUEST['uid'])))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $puid = mysqli_real_escape_string($conn, $_REQUEST['puid']);
    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $did = mysqli_real_escape_string($conn, $_REQUEST['did']);

    $strSQL = "SELECT * FROM vot2_patient_med WHERE ID = '$did'";
    $res = $db->fetch($strSQL, false);
    if($res){
        $return['status'] = 'Success';
        $return['data'] = $res;
        echo json_encode($return);
        $db->close(); 
        die();
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
        echo json_encode($return);
        $db->close(); 
        die();
    }
}

if($stage == 'confirm_patient_drug'){
    if(
        (!(isset($_REQUEST['puid']))) ||
        (!(isset($_REQUEST['uid']))) ||
        (!(isset($_REQUEST['reason']))) ||
        (!(isset($_REQUEST['reason_inf'])))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $puid = mysqli_real_escape_string($conn, $_REQUEST['puid']);
    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $reason = mysqli_real_escape_string($conn, $_REQUEST['reason']);
    $reason_inf = mysqli_real_escape_string($conn, $_REQUEST['reason_inf']);

    $cnf_session = $dateuniversal;

    // $strSQL = "UPDATE vot2_patient_med SET med_status = 'N', med_cnf = 'N' WHERE med_transaction IS NOT NULL AND med_pid = '$puid' AND med_cnf = 'Y'";
    // $res = $db->execute($strSQL);

    $strSQL = "SELECT * FROM vot2_patient_med WHERE med_status = 'Y' AND med_delete = 'N' AND med_pid = '$puid' AND med_transaction IS NOT NULL" ;
    $res = $db->fetch($strSQL, true, false);
    if(($res) && ($res['status'])){
        foreach ($res['data'] as $row) {
            $strSQL = "INSERT INTO vot2_patient_med (`med_pid`, `med_username`, `med_id`, `med_name`, `med_amount`, `med_mg`, `med_desc`, `med_status`, `med_udatetime`)
                  VALUES ('$puid ', '".$row['med_username']."', '".$row['med_id']."', '".$row['med_name']."', '".$row['med_amount']."', '', '".$row['med_desc']."', 'Y', '$datetime')";
            $resInsert = $db->insert($strSQL, false);
        }
    }


    $strSQL = "UPDATE vot2_patient_med SET med_transaction = '$cnf_session', med_cnf = 'Y' WHERE med_transaction IS NULL AND med_pid = '$puid'";
    $res = $db->execute($strSQL);

    if($res){

        $strSQL = "UPDATE vot2_med_transaction SET mt_status = 'N' WHERE mt_patient_uid = '$puid'";
        $res2 = $db->execute($strSQL);

        $strSQL = "INSERT INTO vot2_med_transaction (`mt_transaction_id`, `mt_patient_uid`, `mt_uid`, `mt_datetime`, `mt_stage`, `mt_info`)
                   VALUES ('$cnf_session', '$puid', '$uid', '$datetime', '$reason', '$reason_inf')
                  ";
        $res2 = $db->insert($strSQL, false);

        $strSQL = "UPDATE vot2_patient_med SET med_status = 'N', med_cnf = 'N' WHERE med_transaction != '$cnf_session' AND med_pid = '$puid'";
        $res = $db->execute($strSQL);

        if($res2){
            $return['status'] = 'Success';
        }else{
            $return['status'] = 'Fail';
            $return['error_stage'] = '2';
            $return['error_cmd'] = $strSQL;
        }
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '3';
    }
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'update_drug'){
    if(
        (!(isset($_REQUEST['puid']))) ||
        (!(isset($_REQUEST['uid']))) ||
        (!(isset($_REQUEST['drug_id']))) ||
        (!(isset($_REQUEST['drug_med_id']))) ||
        (!(isset($_REQUEST['drug_q'])))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $puid = mysqli_real_escape_string($conn, $_REQUEST['puid']);
    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $drug_id = mysqli_real_escape_string($conn, $_REQUEST['drug_id']);
    $drug_q = mysqli_real_escape_string($conn, $_REQUEST['drug_q']);
    $drug_info = mysqli_real_escape_string($conn, $_REQUEST['drug_info']);
    $drug_med_id = mysqli_real_escape_string($conn, $_REQUEST['drug_med_id']);
    $drug_name = mysqli_real_escape_string($conn, $_REQUEST['drug_name']);

    $strSQL = "UPDATE vot2_patient_med SET med_status = 'N' WHERE med_pid = '$puid' AND ID = '$drug_id'";
    $res = $db->execute($strSQL);

    if($res){
        $strSQL = "SELECT username FROM vot2_account WHERE uid = '$puid' LIMIT 1";
        $resU = $db->fetch($strSQL, false);

        $pusername = $resU['username'];

        $strSQL = "INSERT INTO vot2_patient_med (`med_pid`, `med_username`, `med_id`, `med_name`, `med_amount`, `med_mg`, `med_desc`, `med_status`, `med_udatetime`)
                    VALUES ('$puid ', '$pusername', '$drug_med_id', '$drug_name', '$drug_q', '', '$drug_info', 'Y', '$datetime')";
        $resInsert = $db->insert($strSQL, false);
        if($resInsert){

            $strSQL = "UPDATE vot2_med_transaction SET mt_status = 'N' WHERE mt_patient_uid = '$puid'";
            $res2 = $db->execute($strSQL);

            $return['status'] = 'Success';
            echo json_encode($return);
            $db->close(); 
            die();
        }else{
            $return['status'] = 'Fail';
            $return['error_stage'] = '4';
            echo json_encode($return);
            $db->close(); 
            die();
        }
    }
}

if($stage == 'delete_patient_drug'){
    if(
        (!(isset($_REQUEST['did']))) ||
        (!(isset($_REQUEST['puid']))) ||
        (!(isset($_REQUEST['uid'])))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $puid = mysqli_real_escape_string($conn, $_REQUEST['puid']);
    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $did = mysqli_real_escape_string($conn, $_REQUEST['did']);

    $strSQL = "UPDATE vot2_patient_med SET med_delete = 'Y', med_status = 'N' WHERE med_pid = '$puid' AND ID = '$did'";
    $res = $db->execute($strSQL);
    if($res){

        $strSQL = "UPDATE vot2_patient_med SET med_cnf = 'N' WHERE med_pid = '$puid'";
        $res = $db->execute($strSQL);

        $strSQL = "UPDATE vot2_med_transaction SET mt_status = 'N' WHERE mt_patient_uid = '$puid'";
        $res2 = $db->execute($strSQL);

        $return['status'] = 'Success';
        $return['data'] = $res['data'];
        echo json_encode($return);
        $db->close(); 
        die();
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
        echo json_encode($return);
        $db->close(); 
        die();
    }
}

if($stage == 'updatemonitor'){
    if(
        (!(isset($_POST['puid']))) ||
        (!(isset($_POST['uid']))) ||
        (!(isset($_POST['start_mon']))) ||
        (!(isset($_POST['end_mon'])))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $puid = mysqli_real_escape_string($conn, $_POST['puid']);
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $start = mysqli_real_escape_string($conn, $_POST['start_mon']);
    $end = mysqli_real_escape_string($conn, $_POST['end_mon']);

    $strSQL = "UPDATE vot2_account SET start_obsdate = '$start', end_obsdate = '$end', cal_end_obsdate = '$end' WHERE uid = '$puid'";
    $db->execute($strSQL);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`) VALUES ('$datetime', 'ปรับปรุงวันที่เริ่มและสิ้นสุดการติดตาม', 'Target UID > $puid', '$remote_ip', '$uid')";
    $db->insert($strSQL, false);
    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'patient_delete'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['patient_id']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $patient_id = mysqli_real_escape_string($conn, $_GET['patient_id']);


    $strSQL = "UPDATE vot2_account SET delete_status = '1' WHERE username = '$patient_id' ";
    $res = $db->execute($strSQL, false);

    $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`)
        VALUES ('$datetime', 'ลบผู้ป่วย', 'Target TB NO : $patient_id', '$remote_ip', '$uid')
    ";
    $db->insert($strSQL, false);

    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'back2follow'){
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['puid']))
    ){
        $return['status'] = 'Fail (x101)';
        $return['error_stage'] = '2';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $puid = mysqli_real_escape_string($conn, $_REQUEST['puid']);

    $strSQL = "SELECT * FROM vot2_account WHERE uid = '$puid' LIMIT 1";
    $res = $db->fetch($strSQL, false);

    if($res){
        $caldate = $res['cal_end_obsdate'];
        $stopdate = $res['end_obsdate'];
        // Check จำนวนวัน จากวันที่หยุดล่าสุด ถึงวันที่ควรหยุด (Calculated date)

        $contractDateBegin = new DateTime($stopdate);
        $contractDateEnd  = new DateTime($caldate);

        $interval = $contractDateBegin->diff($contractDateEnd);
        $numday = $interval->format('%a');

        $newCalculateDay = date('Y-m-d', strtotime('+'.$numday.' days') );

        $strSQL = "UPDATE vot2_account 
                   SET 
                   end_obsdate = '$newCalculateDay', 
                   cal_end_obsdate = '$newCalculateDay', 
                   stop_drug = '0' 
                   WHERE 
                   uid = '$puid'
                   AND delete_status = '0'
                   AND active_status = '1'
                   ";
        $resU = $db->execute($strSQL);

        $return['status'] = 'Success';
        $return['data'] = number_format($numday);
    }else{
        $return['status'] = 'Fail (x101)';
        $return['error_stage'] = '3';
    }
    
    echo json_encode($return);
    $db->close(); 
    die();
}