<?php 
header("Access-Control-Allow-*: *");
$return = array();
$return['a'] = '123';
$return['b'] = 'asd';
echo json_encode($return);
?>