<?php 
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

include '../../vendor/autoload.php';

$db = new Database();
$conn = $db->conn();


if(
    (!isset($_GET['uid']))
){
    $return['status'] = 'Fail (x101)';
    echo json_encode($return);
    $db->close(); 
    die();
}

$uid = mysqli_real_escape_string($conn, $_GET['uid']);
$vid = mysqli_real_escape_string($conn, $_GET['vid']);

if (!empty($_FILES)) {
    $path = '../uploads/video/';
    if (!file_exists($path)) {
        mkdir($path, 0755, true);
    }

    $originalName = $_FILES['file']['name'];
    $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
    $origin_ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $t=time();
    $uploadExt = $ext;
    if($origin_ext != 'mp4'){
        $uploadExt = '.mp4';
    }

    $generatedName = date('U').'-'.$_FILES['file']['name'];
    $uploadName = date('U').'-'.$_FILES['file']['name'].$uploadExt;
    $uploadName_tmp = date('U').'-'.$_FILES['file']['name'];

    $strSQL = "SELECT username, hcode FROM vot2_account WHERE uid = '$uid' AND delete_status = '0'";
    $res = $db->fetch($strSQL, false);

    $username = '';
    $hcode = '';
    if($res){
        $username = $res['username'];

        $bx = explode("/", $username);
        if(sizeof($bx) > 1){
            $username = implode("", $bx);
        }

        $hcode = $res['hcode'];
        $generatedName = $username.'-'.$generatedName;
    }
    
    $filePath = $path.$generatedName;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        $fileUrl = 'https://thvot.com/thvotweb/app/uploads/video/'.$generatedName;

        if($origin_ext != 'mp4'){
            // shell_exec('ffmpeg -i /home/thvot/public_html/thvotweb/app/uploads/video/'.$generatedName.' /home/thvot/public_html/thvotweb/app/uploads/video/'.$uploadName);
            // shell_exec('ffmpeg -i /home/thvot/public_html/thvotweb/app/uploads/video/'.$generatedName.' /home/thvot/public_html/thvotweb/app/uploads/video/'.$uploadName_tmp.".mp4");


            // $x = explode(".", 'https://thvot.com/thvotweb/app/uploads/video/'.$generatedName);
            // if(sizeof($x) > 1){
            //     if($x[sizeof($x) - 1] != 'mp4'){
            //         $fileUrl = 'https://thvot.com/thvotweb/app/uploads/video/'.$x[0].".mp4";
            //     }
            // }

            $x = explode(".", $uploadName_tmp);
            if(sizeof($x) > 1){
                if($x[sizeof($x) - 1] != 'mp4'){
                    $uploadName_tmp = $x[0];
                    $fileUrl = 'https://thvot.com/thvotweb/app/uploads/video/'.$x[0].".mp4";
                }
            }

            // shell_exec('ffmpeg -i /home/thvot/public_html/thvotweb/app/uploads/video/'.$generatedName.' /home/thvot/public_html/thvotweb/app/uploads/video/'.$uploadName_tmp.".mp4");

            shell_exec('ffmpeg -i /home/thvot/public_html/thvotweb/app/uploads/video/'.$generatedName.' -vcodec h264 /home/thvot/public_html/thvotweb/app/uploads/video/'.$uploadName_tmp.".mp4");

            
        }else{
            $x = explode(".", $uploadName_tmp);
            if(sizeof($x) > 1){
                if($x[sizeof($x) - 1] != 'mp4'){
                    $uploadName_tmp = $x[0];
                    $fileUrl = 'https://thvot.com/thvotweb/app/uploads/video/'.$x[0].".mp4";
                }
            }
            
            shell_exec('ffmpeg -i /home/thvot/public_html/thvotweb/app/uploads/video/'.$generatedName.' -vcodec h264 /home/thvot/public_html/thvotweb/app/uploads/video/'.$uploadName_tmp.".mp4");
        }

        $strSQL = "INSERT INTO vot2_followup (`fu_uid`, `fu_username`, `fu_video`, `fu_hoscode`, `fu_date`, `fu_upload_datetime`)
                   VALUES ('$uid', '".$res['username']."', '$fileUrl', '$hcode ', '$date', '$datetime')";
        $db->insert($strSQL, false);

        $strSQLx = $strSQL;

        $strSQL = "UPDATE vot2_followup_dummy SET fud_status = 'in-complete' WHERE fud_uid = '$uid' AND fud_date = '$date'";
        $db->execute($strSQL);

        $strSQL = "INSERT INTO vot2_log (`log_datetime`, `log_info`, `log_message`, `log_ip`, `log_uid`) VALUES ('$datetime', 'อัพโหลดวีดีโอ', '', '$remote_ip', '$uid')";
        $res1 = $db->insert($strSQL, false);

        $strSQL = "INSERT INTO vot2_notification 
                  (
                    `noti_header`, `noti_content`, `noti_datetime`, `noti_type`, `noti_hcode`
                  )
                  VALUES 
                  (
                      'ผู้ป่วยส่งวีดีโอการรับประทานยา', 'การรับประทานยาของวันที่ $date', '$datetime', 'workprocess', '$hcode'
                  )
                  ";
        $res01 = $db->insert($strSQL, true);

        $strSQL = "SELECT MAX(fu_id) mfu_id FROM vot2_followup WHERE fu_uid = '$uid'";
        $res02 = $db->fetch($strSQL, false);

        $strSQL = "UPDATE vot2_videosession SET vs_upload = 'done', vs_upload_datetime = '$datetime', vs_vid = '".$res02['mfu_id']."' WHERE vs_session = '$vid' AND vs_uid = '$uid'";
        $res1 = $db->execute($strSQL); 


        //
        $strSQL = "SELECT obs_uid FROM vot2_account WHERE uid = '$uid' AND delete_status = '0' LIMIT 1";
        $resStaff = $db->fetch($strSQL, false);
        if(($resStaff) && ($resStaff['obs_uid'] != null)){

            $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('ky7UCr1R+Z02rgE4IUujkpubR5e1IOWMI72XpVGOVz94H9YbWEKfDbQnt8r9U08PbZYtSQHYT2jxFHUHNj6O5L8QgX81E4RcZ4mt8RMeruWvEDSnCwHmfHx1ocJbXshH9yPxOoWclP7b56ZGi9PgFQdB04t89/1O/w1cDnyilFU=');
            $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => 'ebbf7cf8ec444c1c9a61959b5cea83c8']);
            
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('ผู้ป่วยรหัส '. $username . ' ได้ทำการส่งวิดีโอประจำวันที่ ' . $date . ' กรุณาตรวจสอบที่นี่');
            // $response = $bot->pushMessage('U4ba9e1e452c9d3160de4924e81da4d6e', $textMessageBuilder);
            $response = $bot->pushMessage($resStaff['obs_uid'], $textMessageBuilder);

        }
        //

        $return['status'] = 'Success';
        echo json_encode($return);
        $db->close(); 
        die();
    }
}else{

    $strSQL = "UPDATE vot2_videosession SET vs_upload = 'fail' WHERE vs_session = '$vid' AND vs_uid = '$uid'";
    $res1 = $db->execute($strSQL); 

    $return['status'] = 'Fail (x102)';
    echo json_encode($return);
    $db->close(); 
    die();
}

$db->close(); 
die();

?>