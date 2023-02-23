<?php
session_start();

include '../vendor/autoload.php';
use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;

$_SESSION['reg_type'] = $_GET['token'];

$config = [
    'callback' => HttpClient\Util::getCurrentUrl(),
    'providers' => [
        'Line' => [
            'enabled' => true,
            'keys'    => [ 'id' => '1656431313', 'secret' => '3ea313c68c20d595542f7de7a119ea4a' ]
        ],
    ],
];

try {
    $hybridauth = new Hybridauth( $config );
    $adapter = $hybridauth->authenticate( 'Line' );
    $tokens = $adapter->getAccessToken();
    $userProfile = $adapter->getUserProfile();
    $ukey = '';
    $uphoto = '';
    foreach ($userProfile as $key => $value) {
      if($key == 'identifier'){
        $ukey = $value;
      }

      if($key == 'photoURL'){
        $uphoto = $value;
      }
    }

    

    header('Location: ../app/controller/auth?stage=line_login_web&token='.$ukey);
    $adapter->disconnect();
}
catch (\Exception $e) {
    echo $e->getMessage();
}
