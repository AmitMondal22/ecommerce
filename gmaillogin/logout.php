<?php
require_once __DIR__ . '/vendor/autoload.php';

session_start();

$client = new Google\Client();
$client->setClientId('1054276787193-vf0lu9qqfjua27je5mlq1q4ekm2qnmsr.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/lt-main/logout.php');

if (isset($_GET['code'])) {
    $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $accessToken = $client->getAccessToken();
    
    $oauth2 = new Google\Service\Oauth2($client);
    $userInfo = $oauth2->userinfo->get();
    
    // Now you can use $userInfo to access user data
    var_dump($userInfo);
}
?>
