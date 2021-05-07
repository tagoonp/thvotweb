<?php 
require("../database_config/thvot/config.inc.php");
require('./configuration.php');
require('./database.php'); 

$db = new Database();
$conn = $db->conn();

$stage = false;

if((!isset($_REQUEST['stage'])) || ($_REQUEST['stage'] == '') || ($_REQUEST['stage'] == null)){
    $db->close($conn);
    die();
}

$stage = mysqli_real_escape_string($conn, $_REQUEST['stage']);

if($stage == 2){ // Checkcode
    if(!isset($_REQUEST['code'])){
        $db->close($conn);
        die();
    }
    $code = mysqli_real_escape_string($conn, $_REQUEST['code']);
    $strSQL = "SELECT * FROM vot2_registercode WHERE regcode_code = '$code' AND regcode_use = '0'";
    $result = $db->fetch($strSQL, true, true);
    // var_dump($strSQL);
    if(($result) && ($result['status']) && ($result['count'] > 0)){
        echo "Success";
    }else{
        echo "Fail";
    }
    $db->close($conn);
    die();
}