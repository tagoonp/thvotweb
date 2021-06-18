<?php 
// curl -v -X POST https://api.line.me/v2/bot/message/multicast \
// -H 'Content-Type: application/json' \
// -H 'Authorization: Bearer {ky7UCr1R+Z02rgE4IUujkpubR5e1IOWMI72XpVGOVz94H9YbWEKfDbQnt8r9U08PbZYtSQHYT2jxFHUHNj6O5L8QgX81E4RcZ4mt8RMeruWvEDSnCwHmfHx1ocJbXshH9yPxOoWclP7b56ZGi9PgFQdB04t89/1O/w1cDnyilFU=}' \
// -d '{
//     "to": ["U1d5a8a8fe0b1d6df97b6cef6a466ccd2"],
//     "messages":[
//         {
//             "type":"text",
//             "text":"Hello, world1"
//         }
//     ]
// }'

include '../../vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('ky7UCr1R+Z02rgE4IUujkpubR5e1IOWMI72XpVGOVz94H9YbWEKfDbQnt8r9U08PbZYtSQHYT2jxFHUHNj6O5L8QgX81E4RcZ4mt8RMeruWvEDSnCwHmfHx1ocJbXshH9yPxOoWclP7b56ZGi9PgFQdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => 'ebbf7cf8ec444c1c9a61959b5cea83c8']);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
$response = $bot->pushMessage('U1d5a8a8fe0b1d6df97b6cef6a466ccd2', $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
#

?>