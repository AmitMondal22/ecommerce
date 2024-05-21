<?php
require_once __DIR__ . '/vendor/autoload.php';

session_start();

$client = new Google\Client();
$client->setClientId('40096405219-rllnk53radvkbkqsksqgmavooc71qf6f.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/lt-main/payment.php');
$client->addScope('email');

$authUrl = $client->createAuthUrl();
?>

<a href="<?php echo $authUrl; ?>">Login with Google</a>