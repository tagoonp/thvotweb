<?php 
session_start();
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);
$return = array();


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

    $strSQL = "SELECT * FROM patient_username WHERE fu_username = '$patient_username' AND fu_date = '$date'";
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