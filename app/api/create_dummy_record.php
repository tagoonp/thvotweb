<?php 
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

$strSQL = "SELECT * FROM vot2_account WHERE role = 'patient' AND delete_status = '0' AND end_obsdate IS NULL OR end_obsdate <= '$date'";
$res = $db->fetch($strSQL, true, false);
if(($res) && ($res['status'])){
    
}

$db->close();
die();
?>