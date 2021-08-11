<?php 
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

$strSQL = "SELECT * FROM vot2_alerttime 
           WHERE 
           alt_uid IN (SELECT uid FROM vot2_account WHERE active_status = '1' AND delete_status = '0' AND stop_drug = '0' AND role = 'patient')
           AND alt_time ";
$resAlert = $db->fetch($strSQL, true, false);
if(($resAlert) && ($resAlert['status'])){
    $ctime = $datetime;
    $date_now = new DateTime();
    

    foreach ($resAlert['data'] as $row) {
        $date2 = new DateTime($date . " " . $row['alt_time'] . "00");

        if ($date_now > $date2) {
            
        }
    }
}
?>