<?php
include 'vendor/autoload.php';
use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;

$_SESSION['reg_type'] = $_GET['t'];

$config = [
    'callback' => HttpClient\Util::getCurrentUrl(),
    'providers' => [
        'Line' => [
            'enabled' => true,
            'keys'    => [ 'id' => '1656117730', 'secret' => '70107541ff55bb678ef6c89c5c6b19de' ],
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

    

    header('Location: ./app/controller/auth?stage=line_login_staff&t=staff&token='.$ukey.'&photo='.$uphoto);
    $adapter->disconnect();
}
catch (\Exception $e) {
    echo $e->getMessage();
}
