<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Header: *");
$return = array();
$return['a'] = '123';
$return['b'] = 'asd';
echo json_encode($return);
?>