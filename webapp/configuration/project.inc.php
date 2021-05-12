<?php 
if(!isset($_SESSION['vot_pid'])){
    header('Location: ./project-list.php');
    die();
}
?>