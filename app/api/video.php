<?php 
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);
$return = array();

if($stage == 'startvideo'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['vid']))
    ){
        $return['status'] = 'Fail';
        $return['stage_fail'] = '0';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $vid = mysqli_real_escape_string($conn, $_GET['vid']);
    $return['status'] = 'Fail';
    
    $strSQL = "INSERT INTO vot2_videosession (`vs_session`, `vs_uid`, `vs_create`) VALUES ('$vid', '$uid', '$datetime')";
    $res1 = $db->insert($strSQL, false); 

    if($res1){
        $return['status'] = 'Success';
    }
    
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'cancelvideo'){
    if(
        (!isset($_GET['uid'])) ||
        (!isset($_GET['vid']))
    ){
        $return['status'] = 'Fail';
        $return['stage_fail'] = '0';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $vid = mysqli_real_escape_string($conn, $_GET['vid']);
    $return['status'] = 'Fail';
    
    $strSQL = "UPDATE vot2_videosession SET vs_upload = 'cancel' WHERE vs_session = '$vid' AND vs_uid = '$uid'";
    $res1 = $db->execute($strSQL); 
    $return['status'] = 'Success';
    
    echo json_encode($return);
    $db->close(); 
    die();
}

if($stage == 'listUpload'){
    if(
        (!isset($_GET['uid']))
    ){
        $return['status'] = 'Fail (x101)';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_GET['uid']);
    $page = mysqli_real_escape_string($conn, $_GET['page']);
    $limit = mysqli_real_escape_string($conn, $_GET['limit']);
    $page = ($page * $limit) - $limit;

    $strSQL = "SELECT * FROM vot2_videosession WHERE vs_uid = '$uid' AND vs_upload in ('done' , 'fail') ORDER BY vs_create DESC LIMIT $page, $limit";
    $res = $db->fetch($strSQL,true,false);
    if(($res) && ($res['status'])){
        $return['status'] = 'Success';
        // $return['data'] = $res['data'];
        foreach ($res['data'] as $row){
            if($row['vs_upload'] == 'done'){
                $row['vs_img'] = 'https://thvot.com/img/check.png';
            }else{
                $row['vs_img'] = 'https://thvot.com/img/cancel.png';
            }
        }

        $return['data'] = $res['data'];
    }else{
        $return['status'] = 'Fail (x102)'.$strSQL;
    }
    
    echo json_encode($return);
    $db->close(); 
    die();

}

