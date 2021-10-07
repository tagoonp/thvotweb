<?php
header("Access-Control-Allow-Origin: *");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$date = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');
$dateuniversal = date('U');
$year = date('Y');
$remote_ip = $_SERVER['REMOTE_ADDR'];
$timezone = 'Asia/Bangkok';
$app_title = 'NCDx Version 1.0';

date_default_timezone_set($timezone);

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}