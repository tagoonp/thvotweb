<?php 
header("Access-Control-Allow-Origin: *");
$return = array();
$return['a'] = '123';
$return['b'] = 'asd';
echo json_encode($return);
?>