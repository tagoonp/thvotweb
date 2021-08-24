<?php
include '../vendor/autoload.php';
use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;

$config = [
    'callback' => HttpClient\Util::getCurrentUrl(),
    'providers' => [
        'Line' => [
            'enabled' => true,
            'keys'    => [ 'id' => '1656349711', 'secret' => '7628b06da19c5740090ce217a8b43708' ],
        ],
    ],
];

try {
    $hybridauth = new Hybridauth( $config );
    $adapter = $hybridauth->authenticate( 'Line' );
    $tokens = $adapter->getAccessToken();
    $userProfile = $adapter->getUserProfile();
    $ukey = '';
    foreach ($userProfile as $key => $value) {
      if($key == 'identifier'){
        $ukey = $value;
      }
    }

    header('Location: ../app/controller/auth?stage=line_login_mobile&t=vot&token='.$ukey);
    $adapter->disconnect();
}
catch (\Exception $e) {
    echo $e->getMessage();
}
