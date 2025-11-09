<?php
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfig(__DIR__ . '/../google-oauth.json'); // JSON koji si preuzeo
$client->setRedirectUri('http://localhost/SalaHub/public/oauth2callback.php');
$client->addScope(Google_Service_Calendar::CALENDAR);
$client->setAccessType('offline');
$client->setPrompt('consent');

// Ako prvi put dolazimo, preusmeri na Google login
if (!isset($_GET['code'])) {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit;
} else {
    // Nakon logina Google vraća "code"
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (isset($token['error'])) {
        echo "<h3>❌ Greška: " . htmlspecialchars($token['error_description']) . "</h3>";
        exit;
    }

    // Sačuvaj token
    $tokenPath = __DIR__ . '/../google_token.json';
    file_put_contents($tokenPath, json_encode($token));

    echo "<h2>✅ SalaHub uspešno povezan sa Google Calendar nalogom!</h2>";
    echo "<p>Token je sačuvan u <b>google_token.json</b>.</p>";
}
