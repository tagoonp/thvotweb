<?php 
if(!isset($_SESSION['vot_uid'])){
    header('Location: ../');
    die();
}

$uid = $_SESSION['vot_uid'];
$role = $_SESSION['vot_role'];

$strSQL = "SELECT * FROM vot2_account a INNER JOIN vot2_userinfo b ON a.uid = b.info_uid
           WHERE 
           a.uid = '$uid' 
           AND a.role = '$role' 
           AND a.delete_status = '0' 
           AND a.active_status = '1' 
           AND b.info_use = '1' 
           AND b.info_uid = '$uid'
          ";
$result = $db->fetch($strSQL, false);
if($result){
    $user = $result;
}else{
    echo $strSQL;
    die();
    $db->close();
    header('Location: ../');
    die();
}
?>