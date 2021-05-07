<?php 
if(!isset($_SESSION['bnc_uid'])){
    $db->close();
    header('Location: ../login.php');
    die();
}

$uid = $_SESSION['bnc_uid'];
$role = $_SESSION['bnc_role'];

$strSQL = "SELECT * FROM bcn_account WHERE ID = '$uid' AND role = '$role' AND active_status = '1'";
$result = $db->fetch($strSQL, false);
if($result){
    $user = $result;
}else{
    $db->close();
    header('Location: ../login.php');
    die();
}
?>