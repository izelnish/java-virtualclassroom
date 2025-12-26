<?php
// Upload this file to InfinityFree and visit it (http://yoursite/check_gemini.php)
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Gemini Connection Test</h1>";

$apiKey = "AIzaSyC70RuVvyOq7rCBqhqlmqV1Lhj_g-mnETI"; // <--- User might need to edit this, but I'll check without it first or rely on the env if I could.
// Actually, I'll just check connectivity to the domain.

$url = "https://generativelanguage.googleapis.com";

echo "<p>Testing connection to: <strong>$url</strong></p>";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Critical for free hosts
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "<h3 style='color:red'>Connection Failed!</h3>";
    echo "<p>cURL Error: $error</p>";
    echo "<p>Tip: Free hosting sometimes blocks outgoing connections or has outdated SSL certificates.</p>";
} else {
    echo "<h3 style='color:green'>Connection Successful!</h3>";
    echo "<p>HTTP Status: $http_code (404/200/etc is fine, as long as it's not 0)</p>";
}

echo "<hr>";
echo "<h3>PHP Configuration:</h3>";
echo "allow_url_fopen: " . (ini_get('allow_url_fopen') ? 'ON' : 'OFF') . "<br>";
echo "cURL extension: " . (function_exists('curl_init') ? 'Installed' : 'Missing') . "<br>";
?>
