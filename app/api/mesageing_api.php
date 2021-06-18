<?php 

require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

include 'vendor/autoload.php';
// use Hybridauth\Hybridauth;
// use Hybridauth\HttpClient;

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('Nsit7f84/ZoTOjmdwgTjTn61qBGK9pESa0+63be4mMR424eDYfCljsehs1bhmh6xmBfMQdLIeTo8ccDVVkoKZYR1ifw/j70+Pnnga0as/y1AVYNuhFULeKZpaOfZJ5R1BYB/PCv65yzyUsUzYmOnigdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '99ff5677d95f117fb4ad1d0cf1ff270b']);

$response = $bot->replyText('U1d5a8a8fe0b1d6df97b6cef6a466ccd2', 'hello!');
if ($response->isSucceeded()) {
    echo 'Succeeded!';
    return;
}

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
?>