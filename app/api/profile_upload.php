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

if (!empty($_FILES)) {
    $path = '../uploads/';

    $originalName = $_FILES['file']['name'];
    $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
    $origin_ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $t=time();
    $uploadExt = $ext;

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
        $fileUrl = 'https://thvot.com/thvotweb/app/uploads/'.$generatedName;

        $strSQL = "UPDATE vot2_account SET profile_img = '$fileUrl' WHERE uid = '$uid' AND delete_status = '0'";
        $db->execute($strSQL);
        echo "Y";
        $db->close(); 
        die();
    }
}else{
    echo "N";
    $db->close(); 
    die();
}

$db->close(); 
die();

?>