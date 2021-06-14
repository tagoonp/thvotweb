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

if($stage == 'check4month'){

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