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
    if((!isset($_REQUEST['username'])) || (!isset($_REQUEST['email']))){
        $db->close($conn);
        die();
    }
    $username = mysqli_real_escape_string($conn, $_REQUEST['username']);
    $email = mysqli_real_escape_string($conn, $_REQUEST['email']);

    $strSQL = "SELECT * FROM vot2_account WHERE (username = '$username' OR email = '$email') AND delete_status = '0' ";
    $result = $db->fetch($strSQL, true, true);
    
    if(($result) && ($result['status']) && ($result['count'] > 0)){
        echo "Duplicate";
    }
    $db->close($conn);
    die();
}