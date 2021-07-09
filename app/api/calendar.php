<?php 
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = new Database();
$conn = $db->conn();

header('Content-Type: application/json');

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);
$return = array();

if($stage == 'getpatient_calendar'){
    if(!isset($_GET['patient_id'])){
        $return['status'] = 'Fail';
        $return['stage_fail'] = '0';
        echo json_encode($return);
        $db->close(); 
        die();
    }

    $patient_id = mysqli_real_escape_string($conn, $_GET['patient_id']);

    $strSQL = "SELECT start_obsdate, end_obsdate FROM vot2_account WHERE uid = '$patient_id' AND role = 'patient' AND delete_status = '0' LIMIT 1";
    $res = $db->fetch($strSQL, false);

    if($res){
        $start = $res['start_obsdate'];
        $end = $res['end_obsdate'];

        $start_date = strtotime($start);
        $end_date = strtotime($end);

        $curr_date = strtotime($date);

        $date_diff = ($end_date - $start_date)/60/60/24;

        for ($i=0; $i < $date_diff; $i++) { 
            $buf = array();
            
            


            $strSQL = "SELECT fud_status, fud_comment, fud_dateview FROM vot2_followup_dummy WHERE fud_date = '$start' AND fud_uid = '$patient_id'";
            $res2 = $db->fetch($strSQL, false);

            if($res2){
                $buf['allDay'] = true;
                $buf['start'] = $start;
                $buf['status'] = $res2['fud_status'];

                if($i == 0){
                    $buf['title'] = 'bx bxs-star';
                }else{
                    $buf['title'] = '';
                }

                if($res2['fud_status'] == 'in-complete'){ // ไม่ส่ง 
                    if($res2['fud_comment'] == null){ // ไม่ชี้แจง 
                        $buf['color'] = '#0077ff'; 
                    }else{ // ชี้แจง
                        $buf['color'] = '#0077ff'; 
                    }
                }else if($res2['fud_status'] == 'sended'){
                    if($res2['fud_dateview'] == '1'){ // ได้ดู
                        $buf['color'] = '#ff6246'; // ส่ง ได้ดู 
                    }else{ // ไม่ได้ดู
                        if($res2['fud_comment'] == null){ // ไม่ชี้แจง 
                            $buf['color'] = '#ff6246'; 
                        }else{ // ชี้แจง
                            $buf['color'] = '#fff'; 
                            $buf['borderColor'] = '#ff6246';
                        }
                    }
                    
                }else{
                    $buf['color'] = '#0077ff';

                }

                $return[] = $buf;
            }else{
                // $buf['err'] = $strSQL;
            }

            

            $start = Date("Y-m-d", strtotime("$start +1 days"));  
        }

        

        // if(($start != null) && ($end != null)){
            
        //     do {
        //         $buf = array();

        //         $strSQL = "SELECT fud_status, fud_comment, fud_dateview FROM vot2_followup_dummy WHERE fud_date = '$start' AND fud_uid = '$patient_id'";
        //         $res2 = $db->fetch($strSQL, false);
        //         if($res2){
        //             if(($res2['fud_status'] == 'in-complete') && ($res2['fud_comment'] == null)){
        //                 $buf['color'] = '#ff6246'; // ไม่ส่ง ไม่ชี้แจง 
        //             }else if(($res2['fud_status'] == 'in-complete') && ($res2['fud_comment'] != null) && ($res2['fud_comment'] != '')){
        //                 $buf['color'] = '#ff6246'; // ไม่ส่ง ชี้แจง 
        //             }else if(($res2['fud_status'] == 'complete') && ($res2['fud_dateview'] == '1')){
        //                 $buf['color'] = '#ff6246'; // ส่ง ได้ดู 
        //             }else if(($res2['fud_status'] == 'complete') && ($res2['fud_dateview'] == '0') && ($res2['fud_comment'] != '') && ($res2['fud_comment'] != null)){
        //                 $buf['color'] = '#ff6246'; // ส่ง ชี้แจง 
        //             }else if($res2['fud_status'] == 'complete'){
        //                 $buf['color'] = '#000';
        //             }
        //         }else{
        //             $buf['color'] = '#000';
        //         }

        //         $buf['allDay'] = false;
        //         $buf['start'] = $start;

        //         $return['status'] = 'Success';
        //         $return['data'] = 

        //         $start = date($start, strtotime('+1 days'));
        //     }while (($start != $end) && ($start <= $date));
        // }
    }else{
        echo $strSQL;
    }

    echo json_encode($return, JSON_PRETTY_PRINT);
    $db->close(); 
    die();
}
?>