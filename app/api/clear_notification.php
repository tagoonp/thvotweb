<?php 
require('../config/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

$strSQL = "UPDATE vot2_notification SET noti_hide = '1' WHERE noti_datetime < '$datetime'";
$res = $db->execute($strSQL);

$db->close();
die();
?>