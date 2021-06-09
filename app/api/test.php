<?php 
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: *");
$return = array();
$return['a'] = '123';
$return['b'] = 'asd';
echo json_encode($return);
?>