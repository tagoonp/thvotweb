<?php 
require('../config/config.inc.php');
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

    $strSQL = "SELECT start_obsdate, end_obsdate, cal_end_obsdate FROM vot2_account WHERE uid = '$patient_id' AND role = 'patient' AND delete_status = '0' LIMIT 1";
    $res = $db->fetch($strSQL, false);

    if($res){

        $start = $res['start_obsdate'];
        $end = $res['cal_end_obsdate'];

        $start_date = strtotime($start);
        $end_date = strtotime($end);

        $curr_date = strtotime($date);

        $date_diff = (($end_date - $start_date)/60/60/24) + 1;

        for ($i=0; $i < $date_diff; $i++) { 

            $buf = array();
            $strSQL = "SELECT fud_status, fud_comment, fud_dateview, fud_date, fud_anycall, fud_followstage FROM vot2_followup_dummy WHERE fud_date = '$start' AND fud_uid = '$patient_id'";
            $res2 = $db->fetch($strSQL, false);

            if($res2){
                $buf['allDay'] = true;
                $buf['start'] = $start;
                $buf['status'] = $res2['fud_status'];

                if($i == 0){
                    if($res2['fud_anycall'] == 1){
                        $buf['title'] = '<i class="bx bxs-star"></i> <i class="bx bxs-phone-call"></i>';
                    }else{
                        $buf['title'] = '<i class="bx bxs-star"></i>';
                    }
                }else{
                    $buf['title'] = '&nbsp;';
                    if($res2['fud_anycall'] == 1){
                        $buf['title'] = '<i class="bx bxs-phone-call"></i>';
                    }
                }

                $buf['textColor'] = '#fff';
                
                if($res2['fud_followstage'] == '0'){ // สั่งหยุุดยา
                    $buf['color'] = '#000'; 
                    $buf['borderColor'] = '#000';
                    if($res2['fud_anycall'] == 1){
                        $buf['textColor'] = '#fff';
                    }
                }else{
                    if($res2['fud_status'] == 'non-response'){      // ไม่ส่ง 
                        if($res2['fud_comment'] == null){           // ไม่ชี้แจง
                            $buf['color'] = '#ff8400'; 
                            $buf['borderColor'] = '#ff8400';
                            if($res2['fud_anycall'] == 1){
                                $buf['textColor'] = '#fff';
                            }
                        }else{                                       // ชี้แจง
                            $buf['color'] = '#fff'; 
                            $buf['borderColor'] = '#ff8400';
                            if($res2['fud_anycall'] == 1){
                                $buf['textColor'] = '#ff8400';
                            }
                        }
                    }else if($res2['fud_status'] == 'in-complete'){ 
                        
                        $buf['color'] = '#b10000'; 
                        $buf['borderColor'] = '#b10000';

                    }else if($res2['fud_status'] == 'complete'){
                        $buf['color'] = '#02b869';
                        if($res2['fud_anycall'] == 1){
                            $buf['textColor'] = '#fff';
                        }
                    }
                }
                


                $buf['url'] = "Javascript:viewCommentDialog('".$res2['fud_date']."')";
                if($start == $date){
                    $buf['url'] = "Javascript:viewCommentDialog('".$res2['fud_date']."', '1')";
                }


                if($res2['fud_followstage'] == 0){
                    $buf['color'] = '#000'; 
                    $buf['title'] .= '&nbsp;';
                    $buf['textColor'] = '#fff';
                    $buf['borderColor'] = '#000';
                }
                $return[] = $buf;
            }else{
                if($start <= $date){
                    $buf['title'] = '<i class="bx bxs-star"></i>';
                    $buf['allDay'] = true;
                    $buf['start'] = $start;
                    $buf['status'] = "NA";
                    // $buf['err'] = $strSQL;
                    // $buf['color'] = '#000'; 
                    // $buf['title'] = '&nbsp;';
                    $buf['textColor'] = '#fff';
                    // $buf['borderColor'] = '#000';

                    $buf['color'] = '#ff8400'; 
                    $buf['borderColor'] = '#ff8400';

                    $return[] = $buf;
                }
            }

            // if($res['cal_end_obsdate'] != $res['end_obsdate']){
            //     $buf['color'] = '#000'; 
            //     $buf['title'] = '&nbsp;';
            //     $buf['textColor'] = '#fff';
            //     $buf['borderColor'] = '#000';
            //     $return[] = $buf;
            // }else{
                
            // }
            $start = Date("Y-m-d", strtotime("$start +1 days"));  
        }
    }else{
        echo $strSQL;
    }

    echo json_encode($return, JSON_PRETTY_PRINT);
    $db->close(); 
    die();
}
?>