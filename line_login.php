<?php
include 'vendor/autoload.php';
use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;

$config = [
    'callback' => HttpClient\Util::getCurrentUrl(),
    'providers' => [
        'Line' => [
            'enabled' => true,
            'keys'    => [ 'id' => '1655772627', 'secret' => '1d0318a07b154d2dbeda9eb231edb136' ],
            // 'keys'    => [ 'id' => '1656089414', 'secret' => '2e2b54fd3e2086404921781be0ff32bc' ],
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
    header('Location: ./app/controller/auth?stage=line_login&token='.$ukey);
    
    $adapter->disconnect();
}
catch (\Exception $e) {
    echo $e->getMessage();
}
