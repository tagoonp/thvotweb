<?php 
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

$strSQL = "SELECT * FROM vot2_account 
           WHERE 
           role = 'patient' 
           AND patient_type IN ('VOT', 'TESTER')
           AND delete_status = '0' 
           AND (cal_end_obsdate IS NULL OR cal_end_obsdate >= '$date')
           AND uid NOT IN (SELECT fud_uid FROM vot2_followup_dummy WHERE fud_date = '$date')
           ";
$res = $db->fetch($strSQL, true, false);
if(($res) && ($res['status'])){
    foreach($res['data'] as $row) {
        $strSQL = "INSERT INTO vot2_followup_dummy (`fud_uid`, `fud_username`, `fud_status`, `fud_date`, `fud_followstage`)
                   VALUES ('".$row['uid']."', '".$row['username']."', 'non-response', '$date', '1')";

        $strSQLmc = "SELECT SUM(med_amount) cn FROM vot2_patient_med WHERE med_username = '".$row['username']."' AND med_pid = '".$row['uid']."' AND med_cnf = 'Y'";
        $resMc = $db->fetch($strSQLmc, false);
        $ref = 0;
        if($resMc){
            $ref = $resMc['cn'];
        }

        $strSQL2 = "INSERT INTO vot2_patient_med_dummy (`pmd_username`, `pmd_date`, `pmd_q_ref`, `pmd_monitor`)
                    VALUES ('".$row['username']."', '$date', '$ref', '1')
                   ";
        if($row['stop_drug'] == 1){
            $strSQL = "INSERT INTO vot2_followup_dummy (`fud_uid`, `fud_username`, `fud_status`, `fud_date`, `fud_followstage`)
                       VALUES ('".$row['uid']."', '".$row['username']."', 'non-response', '$date', '0') ";
            
            $strSQL2 = "INSERT INTO vot2_patient_med_dummy (`pmd_username`, `pmd_date`, `pmd_q_ref`, `pmd_monitor`)
                        VALUES ('".$row['username']."', '$date', '$ref', '0')
                    ";
        }
        $res2 = $db->insert($strSQL, false);
        $res3 = $db->insert($strSQL2, false);
        
        if($res2){
            echo "Success<br>";
        }
    }
}

$db->close();
die();
?>