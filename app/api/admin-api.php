<?php 
session_start();
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);

if($stage == 'add_hcode'){

    if(
        (!isset($_REQUEST['target_hcode']))
    ){
        $db->close(); die();
    }

    $hcode = mysqli_real_escape_string($conn, $_POST['target_hcode']);

    $strSQL = "SELECT * FROM vot2_projecthospital WHERE phoscode = '$hcode'";
    $result = $db->fetch($strSQL, false);
    if($result){
        $strSQL = "UPDATE vot2_projecthospital SET phosstatus = 'Y' WHERE phoscode = '$hcode'";
        $r2 = $db->execute($strSQL);
        echo "Success";
        $db->close();
        die();
    }

    $strSQL = "INSERT INTO vot2_projecthospital (`phoscode`, `phosstatus`, `hserv`, `hlat`, `hlng`, `hamp`, `htum`, `hosname`, `htype_code`) 
               VALUE ('$hcode', '$hcode', '$hcode', '$hcode', '$hcode', '$hcode', '$hcode', '$hcode', '$hcode')";
    $result = $db->insert($strSQL, false);
    if($result){
        echo "Success";
        $db->close();
        die();
    }
}if($stage == 'remove_hcode'){

    if(
        (!isset($_REQUEST['target_hcode']))
    ){
        $db->close(); die();
    }

    $hcode = mysqli_real_escape_string($conn, $_POST['target_hcode']);

    $strSQL = "DELETE FROM vot2_projecthospital WHERE phoscode = '$hcode'";
    $result = $db->execute($strSQL);

    echo "Success";
    $db->close();
    die();    

}else{
  $db->close(); header('Location: ../404?error=x909'); die();
}



?>