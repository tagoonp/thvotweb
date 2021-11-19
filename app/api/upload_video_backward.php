<?php
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

include '../../vendor/autoload.php';

$db = new Database();
$conn = $db->conn();

if(!isset($_POST['txtUidUpload'])){
  mysqli_close($conn);
  die();
}

if(!isset($_POST['txtRoleUpload'])){
  mysqli_close($conn);
  die();
}

if(!isset($_POST['txtHcodeUpload'])){
  mysqli_close($conn);
  die();
}


// You need to add server side validation and better error handling here
$data = array();


$hcode = mysqli_real_escape_string($conn, $_POST['txtHcodeUpload']);
$role = mysqli_real_escape_string($conn, $_POST['txtRoleUpload']);
$uid = mysqli_real_escape_string($conn, $_POST['txtUidUpload']);



if(isset($_GET['files']))
{
    $error = false;
    $files = array();

    // $path = "../../tmp_file/".$id_rs;
    $path = '../uploads/video/';
    if (!file_exists($path)) {
        mkdir($path, 0755, true);
    }
    

    foreach($_FILES as $file){

        $originalName = $file['name'];
        $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
        $origin_ext = pathinfo($originalName, PATHINFO_EXTENSION);
        $t=time();
        $uploadExt = $ext;
        if($origin_ext != 'mp4'){
            $uploadExt = '.mp4';
        }

        $generatedName = date('U').'-'.$file['name'];
        $uploadName = date('U').'-'.$file['name'].$uploadExt;
        $uploadName_tmp = date('U').'-'.$file['name'];

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
            $generatedName = trim($username).'-'.$generatedName;
        }
        
        $filePath = $path.$generatedName;

        if(move_uploaded_file($file['tmp_name'], $filePath))
        {
            echo "Y";
            $fileUrl = 'https://thvot.com/thvotweb/app/uploads/video/'.$generatedName;

            if($origin_ext != 'mp4'){
                $x = explode(".", $uploadName_tmp);
                if(sizeof($x) > 1){
                    if($x[sizeof($x) - 1] != 'mp4'){
                        $uploadName_tmp = $x[0];
                        $fileUrl = 'https://thvot.com/thvotweb/app/uploads/video/'.$x[0].".mp4";
                    }
                }

                // shell_exec('ffmpeg -i /home/thvot/public_html/thvotweb/app/uploads/video/'.$generatedName.'  -vcodec h264 /home/thvot/public_html/thvotweb/app/uploads/video/'.$uploadName_tmp.".mp4");
                shell_exec('ffmpeg -i /home/thvot/public_html/thvotweb/app/uploads/video/'.$generatedName.' -pix_fmt yuv420p -crf 18 /home/thvot/public_html/thvotweb/app/uploads/video/'.$uploadName_tmp.".mp4");
            }else{
                $x = explode(".", $uploadName_tmp);
                $uploadName_tmp = $x[0];
                $fileUrl = 'https://thvot.com/thvotweb/app/uploads/video/'.$x[0].".mp4";

                shell_exec('ffmpeg -i /home/thvot/public_html/thvotweb/app/uploads/video/'.$generatedName.' -pix_fmt yuv420p -crf 18 /home/thvot/public_html/thvotweb/app/uploads/video/'.$x[0].".mp4");
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

            // $strSQL = "UPDATE vot2_videosession SET vs_upload = 'done', vs_upload_datetime = '$datetime', vs_vid = '".$res02['mfu_id']."' WHERE vs_session = '$vid' AND vs_uid = '$uid'";
            // $res1 = $db->execute($strSQL); 


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

            // echo "Y";
            // $data = array('success' => 'Form was submitted', 'formData' => $_POST);
            // echo json_encode($return);
            // $db->close(); 
            // die();

        }
        else
        {
            echo "Fail 1";
            $error = true;
        }
    }

    $data = ($error) ? array('error' => 'There was an error uploading your files') : array('Success' => 'Form was uploaded');
}
else
{
    $data = array('Success' => 'Form was submitted', 'formData' => $_POST);
    echo "Fail 2";
}

echo json_encode($data);
mysqli_close($conn);
die();
?>
