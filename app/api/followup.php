<?php 
// session_start();
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);
$return = array();

if($stage == 'unwatch_number'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['role'])) ||
        (!isset($_GET['hcode']))
    ){
        $return['status'] = 'Fail';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $role = mysqli_real_escape_string($conn, $_GET['role']);
    $hcode = mysqli_real_escape_string($conn, $_GET['hcode']);

    $strSQL = "SELECT COUNT(a.fu_id) cn FROM vot2_followup a
               WHERE 
               a.fu_view = '0' 
               AND a.fu_delete = '0'
               AND a.fu_username IN 
               AND a.fu_date = '$date'
               (SELECT username FROM vot2_account WHERE obs_hcode = '$hcode') 
              ";
    if($role == 'admin'){
        $strSQL = "SELECT COUNT(a.fu_id) cn FROM vot2_followup a
               WHERE 
               a.fu_view = '0' 
               AND a.fu_date = '$date'
               AND a.fu_delete = '0'";
    }else if($role == 'manager'){
        $strSQL = "SELECT COUNT(a.fu_id) cn FROM vot2_followup a
               WHERE 
               a.fu_view = '0' 
               AND a.fu_delete = '0'
               AND a.fu_date = '$date'
               AND a.fu_username IN 
               (SELECT username FROM vot2_account WHERE obs_hcode = '$hcode' OR reg_hcode = '$hcode' OR hcode = '$hcode') 
               ";
    }
    $res = $db->fetch($strSQL, false);
    if($res){
        $return['status'] = 'Success';
        $return['data'] = $res['cn'];
    }else{
        $return['status'] = 'Success';
        $return['data'] = 0;
    }
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'unwatch24_number'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['role'])) ||
        (!isset($_GET['hcode']))
    ){
        $return['status'] = 'Fail';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $role = mysqli_real_escape_string($conn, $_GET['role']);
    $hcode = mysqli_real_escape_string($conn, $_GET['hcode']);

    $strSQL = "SELECT COUNT(a.fu_id) cn FROM vot2_followup a
               WHERE 
               a.fu_view = '0' 
               AND a.fu_delete = '0'
               AND a.fu_username IN 
               (SELECT username FROM vot2_account WHERE obs_hcode = '$hcode') 
              ";
    if($role == 'admin'){
        $strSQL = "SELECT COUNT(a.fu_id) cn FROM vot2_followup a
               WHERE 
               a.fu_view = '0' 
               AND a.fu_delete = '0'";
    }else if($role == 'manager'){
        $strSQL = "SELECT COUNT(a.fu_id) cn FROM vot2_followup a
               WHERE 
               a.fu_view = '0' 
               AND a.fu_delete = '0'
               AND a.fu_username IN 
               (SELECT username FROM vot2_account WHERE obs_hcode = '$hcode' OR reg_hcode = '$hcode' OR hcode = '$hcode') 
               ";
    }
    $res = $db->fetch($strSQL, false);
    if($res){
        $return['status'] = 'Success';
        $return['data'] = $res['cn'];
    }else{
        $return['status'] = 'Success';
        $return['data'] = 0;
    }
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'untakendrug_list'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['role'])) ||
        (!isset($_GET['hcode']))
    ){
        $return['status'] = 'Fail';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $role = mysqli_real_escape_string($conn, $_GET['role']);
    $hcode = mysqli_real_escape_string($conn, $_GET['hcode']);

    if($role == 'admin'){
        $strSQL = "SELECT *, d.hosname hospital_name FROM vot2_followup_dummy a INNER JOIN vot2_account b ON a.fud_uid = b.uid 
              INNER JOIN vot2_userinfo c ON b.uid = c.info_uid
              INNER JOIN vot2_chospital d ON b.obs_hcode = d.hoscode
              WHERE 
              b.delete_status = '0' 
              AND a.fud_status = 'non-response'
              AND a.fud_date = '$date'
              AND c.info_use = '1'
              LIMIT $page, $limit
              ";
        $res = $db->fetch($strSQL, true, false);
        if(($res) && ($res['status'])){
            $return['status'] = 'Success';

            $a = array();
            foreach($res['data'] as $row){
                $item = array();
                
                $item['uid'] = $row['uid'];
                $item['username'] = $row['username'];
                $item['fname'] = $row['fname'];
                $item['lname'] = $row['lname'];
                $item['hospital_name'] = $row['hospital_name'];
                $item['profile_img'] = $row['profile_img'];
                
                $strSQL = "SELECT COUNT(fud_uid) cn FROM vot2_followup_dummy WHERE fud_uid = '".$row['uid']."'";
                $resp = $db->fetch($strSQL, false);
                if($resp){
                    $item['curedate'] = $resp['cn'];
                }
                $a[] = $item;
            }
            $return['data'] = $a;

            // $return['data'] = $res['data'];
        }else{
            $return['status'] = 'No record';
            $return['return_message'] = $strSQL;
        }
        echo json_encode($return);
        $db->close(); 
        die();
    }else if($role == 'manager'){
        $strSQL = "SELECT *, d.hosname hospital_name FROM vot2_followup_dummy a INNER JOIN vot2_account b ON a.fud_uid = b.uid 
              INNER JOIN vot2_userinfo c ON b.uid = c.info_uid
              INNER JOIN vot2_chospital d ON b.obs_hcode = d.hoscode
              WHERE 
              b.delete_status = '0' 
              AND a.fud_status = 'non-response'
              AND a.fud_date = '$date'
              AND c.info_use = '1'
              AND b.obs_hcode = '$hcode' OR b.reg_hcode = '$hcode' OR b.hcode = '$hcode'
              LIMIT $page, $limit
              ";
        $res = $db->fetch($strSQL, true, false);
        if(($res) && ($res['status'])){
            $return['status'] = 'Success';

            $a = array();
            foreach($res['data'] as $row){
                $item = array();
                
                $item['uid'] = $row['uid'];
                $item['username'] = $row['username'];
                $item['fname'] = $row['fname'];
                $item['lname'] = $row['lname'];
                $item['hospital_name'] = $row['hospital_name'];
                $item['profile_img'] = $row['profile_img'];
                
                $strSQL = "SELECT COUNT(fud_uid) cn FROM vot2_followup_dummy WHERE fud_uid = '".$row['uid']."'";
                $resp = $db->fetch($strSQL, false);
                if($resp){
                    $item['curedate'] = $resp['cn'];
                }
                $a[] = $item;
            }
            $return['data'] = $a;

            // $return['data'] = $res['data'];
        }else{
            $return['status'] = 'No record';
            $return['return_message'] = $strSQL;
        }
        echo json_encode($return);
        $db->close(); 
        die();
    }else if($role == 'staff'){
        $strSQL = "SELECT *, d.hosname hospital_name FROM vot2_followup_dummy a INNER JOIN vot2_account b ON a.fud_uid = b.uid 
              INNER JOIN vot2_userinfo c ON b.uid = c.info_uid
              INNER JOIN vot2_chospital d ON b.obs_hcode = d.hoscode
              WHERE 
              b.delete_status = '0' 
              AND a.fud_status = 'non-response'
              AND a.fud_date = '$date'
              AND c.info_use = '1'
              AND b.obs_hcode = '$hcode'
              LIMIT $page, $limit
              ";
        $res = $db->fetch($strSQL, true, false);
        if(($res) && ($res['status'])){
            $return['status'] = 'Success';

            $a = array();
            foreach($res['data'] as $row){
                $item = array();
                
                $item['uid'] = $row['uid'];
                $item['username'] = $row['username'];
                $item['fname'] = $row['fname'];
                $item['lname'] = $row['lname'];
                $item['hospital_name'] = $row['hospital_name'];
                $item['profile_img'] = $row['profile_img'];
                
                $strSQL = "SELECT COUNT(fud_uid) cn FROM vot2_followup_dummy WHERE fud_uid = '".$row['uid']."'";
                $resp = $db->fetch($strSQL, false);
                if($resp){
                    $item['curedate'] = $resp['cn'];
                }
                $a[] = $item;
            }
            $return['data'] = $a;

            // $return['data'] = $res['data'];
        }else{
            $return['status'] = 'No record';
            $return['return_message'] = $strSQL;
        }
        echo json_encode($return);
        $db->close(); 
        die();
    }
}

if($stage == 'setpatient_dailyprogress'){
    if(
        (!isset($_REQUEST['uid'])) ||
        (!isset($_REQUEST['patient_id'])) ||
        (!isset($_REQUEST['progress_date'])) ||
        (!isset($_REQUEST['progress_stopdrug']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);
    $patient_id = mysqli_real_escape_string($conn, $_REQUEST['patient_id']);
    $progress_date = mysqli_real_escape_string($conn, $_REQUEST['progress_date']);
    $progress_stopdrug = mysqli_real_escape_string($conn, $_REQUEST['progress_stopdrug']);
    $progress_mgs = mysqli_real_escape_string($conn, $_REQUEST['progress_msg']);

    if($date == $progress_date){
        $strSQL = "INSERT INTO vot2_followup_note (fn_note, fn_datetime, fn_date, fn_uid, fn_patient_uid) 
                   VALUES ('$progress_mgs', '$datetime', '$progress_date', '$uid', '$patient_id')
                  ";
        $res = $db->insert($strSQL, false);
        if($res){
            $strSQL = "UPDATE vot2_followup_dummy SET fud_comment = '$progress_mgs' WHERE fud_date = '$progress_date' AND fud_uid = '$patient_id'";
            $res2 = $db->execute($strSQL);

            if($progress_stopdrug == '0'){ // สั่งหยุดยาชั่วคราว
                $strSQL = "UPDATE vot2_account SET end_obsdate = '$date', stop_drug = '1' WHERE uid = '$patient_id' AND delete_status = '0'";
                $res2 = $db->execute($strSQL);

                $strSQL = "UPDATE vot2_followup_dummy SET fud_followstage = '0' WHERE fud_date = '$progress_date' AND fud_uid = '$patient_id'";
                $res2 = $db->execute($strSQL);

            }else{


                $strSQL = "SELECT * FROM vot2_account WHERE uid = '$patient_id' AND delete_status = '0' LIMIT 1";
                $resu = $db->fetch($strSQL, false);

                if($resu['end_obsdate'] != $resu['cal_end_obsdate']){
                    $caldate = $resu['cal_end_obsdate'];
                    $stopdate = $resu['end_obsdate'];
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
                            uid = '$patient_id''
                            AND delete_status = '0'
                            AND active_status = '1'
                            ";
                    $resU = $db->execute($strSQL);
                }


                // $strSQL = "UPDATE vot2_account SET end_obsdate = '$date', stop_drug = '0' WHERE uid = '$patient_id' AND delete_status = '0'";
                // $res2 = $db->execute($strSQL);

                $strSQL = "UPDATE vot2_followup_dummy SET fud_followstage = '1' WHERE fud_date = '$progress_date' AND fud_uid = '$patient_id'";
                $res2 = $db->execute($strSQL);
            }

            $return['status'] = 'Success';

        }else{
            $return['status'] = 'Fail';
            $return['error_stage'] = '2';
        }
    }else{
        $strSQL = "INSERT INTO vot2_followup_note (fn_note, fn_datetime, fn_date, fn_uid, fn_patient_uid) 
                   VALUES ('$progress_mgs', '$datetime', '$progress_date', '$uid', '$patient_id')
                  ";
        $res = $db->insert($strSQL, false);
        if($res){
            $strSQL = "UPDATE vot2_followup_dummy SET fud_comment = '$progress_mgs' WHERE fud_date = '$progress_date' AND fud_uid = '$patient_id'";
            $res2 = $db->execute($strSQL);
            $return['status'] = 'Success';
        }else{
            $return['status'] = 'Fail';
            $return['error_stage'] = '3';
        }
    }

    
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'getpatient_dailyprogress'){
    if(
        (!isset($_REQUEST['patient_id'])) ||
        (!isset($_REQUEST['sdate']))
    ){
        $return['status'] = 'Fail';
        $return['error_stage'] = '1';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $sdate = mysqli_real_escape_string($conn, $_REQUEST['sdate']);
    $patient_id = mysqli_real_escape_string($conn, $_REQUEST['patient_id']);

    $strSQL = "SELECT * FROM vot2_followup_note a INNER JOIN vot2_userinfo b ON a.fn_uid = b.info_uid
              WHERE a.fn_patient_uid = '$patient_id' AND a.fn_date = '$sdate' AND b.info_use = '1'";
    $res = $db->fetch($strSQL, true, false);
    if(($res) && ($res['status'])){
        $return['status'] = 'Success';
        $return['data'] = $res['data'];
    }else{
        $return['status'] = 'Fail';
        $return['error_stage'] = '2';
    }
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'followup_list'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['role'])) ||
        (!isset($_GET['hcode'])) ||
        (!isset($_GET['page'])) ||
        (!isset($_GET['limit']))
    ){
        $return['status'] = 'Fail';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $role = mysqli_real_escape_string($conn, $_GET['role']);
    $hcode = mysqli_real_escape_string($conn, $_GET['hcode']);
    $page = mysqli_real_escape_string($conn, $_GET['page']);
    $limit = mysqli_real_escape_string($conn, $_GET['limit']);
    $page = ($page * $limit) - $limit;
    if($role == 'admin'){
        $strSQL = "SELECT * FROM vot2_notification 
              WHERE 
              noti_allow_admin = '1' 
              AND noti_hide = '0' 
              AND noti_type = 'workprocess'
              LIMIT $page, $limit
              ";
        $res = $db->fetch($strSQL, true, false);
        if(($res) && ($res['status'])){
            $return['status'] = 'Success';
            $a = array();
            foreach($res['data'] as $row){
                $item = array();
                
                $item['noti_id'] = $row['noti_id'];
                $item['noti_header'] = $row['noti_header'];
                $item['noti_content'] = $row['noti_content'];
                $item['noti_datetime'] = $row['noti_datetime'];
                $item['noti_url'] = $row['noti_url'];
                $item['noti_hcode'] = $row['noti_hcode'];
                $item['noti_uid'] = $row['noti_specific_uid'];
                $item['noti_hide'] = $row['noti_hide'];
                
                $strSQL = "SELECT uid FROM vot2_account WHERE username = '".$row['noti_specific_uid']."'";
                $resp = $db->fetch($strSQL, false);
                if($resp){
                    $item['uid'] = $resp['uid'];
                }
                if($row['noti_header'] == 'แจ้งเตือนการสมัครใช้งาน'){
                    $item['noti_redirect'] = 'userinfo';
                    $item['noti_icon'] = 'https://thvot.com/img/register-icon.png';
                }else{
                    $item['noti_redirect'] = 'userinfo';
                    $item['noti_icon'] = 'https://thvot.com/img/notification-icon.png';
                }
                $a[] = $item;
            }
            $return['data'] = $a;
        }else{
            $return['status'] = 'Fail';
        }
        echo json_encode($return);
        $db->close(); 
        die();
    }else if($role == 'manager'){
        $strSQL = "SELECT * FROM vot2_notification 
              WHERE 
              noti_view = '0' 
              AND noti_type = 'workprocess'
              AND nti_hcode IN (
                  SELECT phoscode FROM vot2_projecthospital WHERE hospcode = '$hcode'
              )
              LIMIT $page, $limit
              ";
        $res = $db->fetch($strSQL, true, false);
        if(($res) && ($res['status'])){
            $return['status'] = 'Success';
            $return['data'] = $res['data'];
        }else{
            $return['status'] = 'Fail';
        }
        echo json_encode($return);
        $db->close(); 
        die();
    }else if($role == 'staff'){
        $strSQL = "SELECT *, d.hosname hospital_name FROM vot2_followup_dummy a INNER JOIN vot2_account b ON a.fud_uid = b.uid 
              INNER JOIN vot2_userinfo c ON b.uid = c.info_uid
              INNER JOIN vot2_chospital d ON b.hcode = d.hoscode
              WHERE 
              b.delete_status = '0' 
              AND a.fud_status = 'sended'
              AND a.fud_date = '$date'
              AND c.info_use = '1'
              AND b.hcode = '$hcode'
              LIMIT $page, $limit
              ";
        $res = $db->fetch($strSQL, true, false);
        if(($res) && ($res['status'])){
            $return['status'] = 'Success';

            $a = array();
            foreach($res['data'] as $row){
                $item = array();
                
                $item['uid'] = $row['uid'];
                $item['username'] = $row['username'];
                $item['fname'] = $row['fname'];
                $item['lname'] = $row['lname'];
                $item['hospital_name'] = $row['hospital_name'];
                $item['profile_img'] = $row['profile_img'];
                
                $strSQL = "SELECT COUNT(fud_uid) cn FROM vot2_followup_dummy WHERE fud_uid = '".$row['uid']."'";
                $resp = $db->fetch($strSQL, false);
                if($resp){
                    $item['curedate'] = $resp['cn'];
                }
                $a[] = $item;
            }
            $return['data'] = $a;

            // $return['data'] = $res['data'];
        }else{
            $return['status'] = 'No record';
            $return['return_message'] = $strSQL;
        }
        echo json_encode($return);
        $db->close(); 
        die();
    }
}

if($stage == 'followup_view'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['patient_username']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $patient_username = mysqli_real_escape_string($conn, $_GET['patient_username']);

    $strSQL = "SELECT * FROM vot2_followup WHERE fu_username = '$patient_username' AND fu_date = '$date'";
    $res = $db->fetch($strSQL, true, false);
    if(($res) && ($res['status'])){
        $return['status'] = 'Success';
        $return['data'] = $res['data'];
    }else{
        $return['status'] = 'Fail'.$strSQL;
    }
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'followup_review'){
    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $vid = mysqli_real_escape_string($conn, $_GET['vid']);
    $eff1 = mysqli_real_escape_string($conn, $_GET['eff1']);
    $eff2 = mysqli_real_escape_string($conn, $_GET['eff2']);
    $eff3 = mysqli_real_escape_string($conn, $_GET['eff3']);
    $eff4 = mysqli_real_escape_string($conn, $_GET['eff4']);
    $eff5 = mysqli_real_escape_string($conn, $_GET['eff5']);
    $eff6 = mysqli_real_escape_string($conn, $_GET['eff6']);
    $vstatus = mysqli_real_escape_string($conn, $_GET['vstatus']);
    $sop = mysqli_real_escape_string($conn, $_GET['sop']);

    $ef1 = 0; $ef2 = 0; $ef3 = 0; $ef4 = 0; $ef5 = 0; $ef6 = 0;
    if($eff1 == true){ $ef1 = 1; }
    if($eff2 == true){ $ef2 = 1; }
    if($eff3 == true){ $ef3 = 1; }
    if($eff4 == true){ $ef4 = 1; }
    if($eff5 == true){ $ef5 = 1; }
    if($eff6 == true){ $ef6 = 1; }

    $strSQL = "UPDATE vot2_followup SET 
                fu_eff1 = '$ef1',
                fu_eff2 = '$ef1',
                fu_eff3 = '$ef1',
                fu_eff4 = '$ef1',
                fu_eff5 = '$ef1',
                fu_eff6 = '$ef1',
                fu_status = '$vstatus',
                fu_view = '1',
                fu_verify_pct = '$sop',
                fu_verify_by = '$uid',
                fu_verify_datetime = '$datetime',
                fu_cnf = '1'
                WHERE fu_id = '$vid'
              ";
    $db->execute($strSQL);

    $strSQL = "SELECT * FROM vot2_followup WHERE fu_id = '$vid'";
    $res = $db->fetch($strSQL, false);
    if($res){
       $patient_uid = $res['fu_uid'];
       $patient_date = $res['fu_date'];

       $intime = 0;
       if($patient_date == $date){
        $intime = 1;
       }

       $strSQL = "UPDATE vot2_followup_dummy SET fud_status = '$vstatus', fud_dateview = '$intime', fud_viewdate = '$date', fud_lastedby = '$uid', fud_udatetime = '$datetime'
               WHERE fud_date = '$patient_date' AND fud_uid = '$patient_uid'
              ";
        $db->execute($strSQL);

        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`) VALUES ('$datetime', 'ส่งผลการตรวจสอบวิดีโอ', '', '$remote_ip', '$uid')";
        $db->insert($strSQL, false);
    }

    $return['status'] = 'Success';
    echo json_encode($return);
    $db->close(); 
    die();
    
}

if($stage == 'patient_noti_list'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['role'])) ||
        (!isset($_GET['page'])) ||
        (!isset($_GET['limit']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $role = mysqli_real_escape_string($conn, $_GET['role']);
    $page = mysqli_real_escape_string($conn, $_GET['page']);
    $limit = mysqli_real_escape_string($conn, $_GET['limit']);
    $page = ($page * $limit) - $limit;

    $strSQL = "SELECT * FROM vot2_notification 
              WHERE
              noti_hide = '0' 
              AND noti_type = 'patient_message'
              AND noti_specific_uid IN (SELECT username FROM vot2_account WHERE uid = '$uid')
              LIMIT $page, $limit
              ";
        $res = $db->fetch($strSQL, true, false);
        if(($res) && ($res['status'])){
            $return['status'] = 'Success';
            $a = array();
            foreach($res['data'] as $row){
                $item = array();
                
                $item['noti_id'] = $row['noti_id'];
                $item['noti_header'] = $row['noti_header'];
                $item['noti_content'] = $row['noti_content'];
                $item['noti_datetime'] = $row['noti_datetime'];
                $item['noti_url'] = $row['noti_url'];
                $item['noti_hcode'] = $row['noti_hcode'];
                $item['noti_uid'] = $row['noti_specific_uid'];
                $item['noti_hide'] = $row['noti_hide'];

                $strSQL = "SELECT uid FROM vot2_account WHERE username = '".$row['noti_specific_uid']."'";
                $resp = $db->fetch($strSQL, false);
                if($resp){
                    $item['uid'] = $resp['uid'];
                }
                
                if($row['noti_header'] == 'แจ้งเตือนการรับประทานยา'){
                    $item['noti_redirect'] = 'tabs/tab1';
                    $item['noti_icon'] = 'https://thvot.com/img/drug-noti-icon.png';
                }else{
                    $item['noti_redirect'] = 'tabs/tab1';
                    $item['noti_icon'] = 'https://thvot.com/img/notification-icon.png';
                }

                $a[] = $item;
            }
            $return['data'] = $a;
        }else{
            $return['status'] = 'Fail';
        }
        echo json_encode($return);
        $db->close(); 
        die();
}

if($stage == 'patient_noti_num'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['role']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $role = mysqli_real_escape_string($conn, $_GET['role']);

    $strSQL = "SELECT COUNT(noti_id) cnt FROM vot2_notification 
              WHERE 
              noti_view = '0' 
              AND noti_hide = '0' 
              AND noti_type = 'patient_message'
              AND noti_specific_uid IN (SELECT username FROM vot2_account WHERE uid = '$uid')
              ";
    $res = $db->fetch($strSQL, false);
    if($res){
        if($res['cnt'] != null){
            $return['status'] = 'Success';
            $return['data']['cn'] = $res['cnt'];
        }else{
            $return['status'] = 'Success';
            $return['data']['cn'] = 0;
        }
    }else{
        $return['status'] = 'Success';
        $return['data']['cn'] = 0;
    }
    echo json_encode($return);
    $db->close(); 
    die();
}