<?php 

// echo $_SESSION['thvot_uid'];
// echo $_SESSION['thvot_role'];

// die();

if((!isset($_SESSION['thvot_uid'])) || (!isset($_SESSION['thvot_role']))){
    // echo "Error 1";
    $db->close();
    header('Location: '.ROOT_DOMAIN.'/thvotweb/patient/');   
    die();
    
}

if($_SESSION['thvot_role'] != $active_role){
    // echo "Error 2";
    $db->close();
    header('Location: '.ROOT_DOMAIN.'/thvotweb/patient/');   
    die();
    // header('Location: '.ROOT_DOMAIN);   
}

// $strSQL = "SELECT * FROM vot2_account INNER JOIN vot2_chospital ON vot2_account.hcode = vot2_chospital.hoscode 
//             INNER JOIN vot2_userinfo ON vot2_account.uid = vot2_userinfo.info_uid
//           WHERE 
//           vot2_account.UID = '".$_SESSION['thvot_uid']."' 
//           AND vot2_account.role = '".$_SESSION['thvot_role']."'
//           AND info_use = '1'
//           ";

$strSQL = "SELECT * FROM vot2_account INNER JOIN vot2_chospital ON vot2_account.hcode = vot2_chospital.hoscode 
            INNER JOIN vot2_userinfo ON vot2_account.uid = vot2_userinfo.info_uid
          WHERE 
          vot2_account.UID = '".$_SESSION['thvot_uid']."' 
          AND info_use = '1'
          ";
$user = $db->fetch($strSQL, false);

if(!$user){
    echo "Error 3";
    if($active_role == 'patient'){
        header('Location: ../../../../../patient/'); 
    }else{
        header('Location: '.ROOT_DOMAIN); 
    }
    $db->close();
    die();
}
?>