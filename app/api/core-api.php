<?php 
session_start();
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);

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