<?php 
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

$strSQL = "SELECT * FROM vot2_account WHERE role = 'patient' AND patient_type = 'VOT' AND delete_status = '0' AND end_obsdate IS NULL OR end_obsdate <= '$date'";
$res = $db->fetch($strSQL, true, false);
if(($res) && ($res['status'])){
    foreach ($res['data'] as $row) {
        $strSQL = "INSERT INTO vot2_followup_dummy 
                    (`fud_uid`, `fud_username`, `fud_status`, `fud_date`)
                   VALUES
                   ('".$row['uid']."', '".$row['username']."', 'non-response', '$date')
                  ";
        $res2 = $db->insert($strSQL, false);
        if($res2){
            echo "Success<br>";
        }
    }
}

$db->close();
die();
?>