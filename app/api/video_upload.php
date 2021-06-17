<?php 
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

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

if (!empty($_FILES)) {
    $path = '../uploads/video/';
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
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

    $strSQL = "SELECT username, hcode FROM vot2_account WHERE uid = '$uid' AND delete_status = '0'";
    $res = $db->fetch($strSQL, false);

    $username = '';
    $hcode = '';
    if($res){
        $username = $res['username'];
        $hcode = $res['hcode'];
        $generatedName = $res['username'].'-'.$generatedName;
    }
    
    $filePath = $path.$generatedName;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        $fileUrl = 'https://thvot.com/thvotweb/app/uploads/video/'.$generatedName;

        if($origin_ext != 'mp4'){
            shell_exec('ffmpeg -i /home/thvot/public_html/thvotweb/app/uploads/video/'.$generatedName.' /home/thvot/public_html/thvotweb/app/uploads/video/'.$uploadName);
        }

        $strSQL = "INSERT INTO vot2_followup `fu_uid`, `fu_username`, `fu_video`, `fu_hoscode`, `fu_date`)
                   VALUES ('$uid', '$username', '$fileUrl', '$hcode ', '$date' )";
        $db->insert($strSQL, false);

        $strSQL = "UPDATE vot2_followup_dummy SET fud_status = 'sended' WHERE fud_uid = '$uid' AND fud_date = '$date'";
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
        $res01 = $db->insert($strSQL, false);
        $return['status'] = 'Success';
        echo json_encode($return);
        $db->close(); 
        die();
    }
}else{
    $return['status'] = 'Fail (x102)';
    echo json_encode($return);
    $db->close(); 
    die();
}

$db->close(); 
die();

?>