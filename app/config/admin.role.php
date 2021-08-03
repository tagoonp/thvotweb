<?php 
if((!isset($_SESSION['thvot_session'])) || ($_SESSION['thvot_session'] != session_id())){
    header('Location: '.ROOT_DOMAIN); 
}

$active_role = 'admin';

if($_SESSION['thvot_role'] != $active_role){
    header('Location: '.ROOT_DOMAIN); 
}

$hcode = $_SESSION['thvot_hcode'];
?>