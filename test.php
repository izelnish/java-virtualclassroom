<?php
// Debugging Script for Chat API
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *"); // Force CORS for testing

require_once 'cors.php'; // Check if this exists
require_once 'chat.php'; // Load the chat logic

// Simulate a request manually
echo "<h1>Backend Chat Debugger</h1>";

// Manually set data as if it came from JSON
$_POST['message'] = "Hello, testing from debug script.";
$_POST['context'] = "Debug Mode";

// We need to trick chat.php to run without receiving raw JSON input
// Since chat.php reads from php://input, we can't easily include it directly without modifying it.
// So instead, we will Copy-Paste the core logic here to test it safely.

echo "<hr><h3>Running Manual Curl Test...</h3>";

$apiKey = "AIzaSyC70RuVvyOq7rCBqhqlmqV1Lhj_g-mnETI"; 
$model = "gemini-2.0-flash";
$url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=" . $apiKey;

$payload = [
    "contents" => [
        [
            "role" => "user",
            "parts" => [["text" => "Hello!"]]
        ]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$result = curl_exec($ch);
$error = curl_error($ch);
$info = curl_getinfo($ch);
curl_close($ch);

if ($error) {
    echo "<h2 style='color:red'>CURL Error: $error</h2>";
} else {
    echo "<h2>HTTP Status: " . $info['http_code'] . "</h2>";
    echo "<h3>Raw Response:</h3>";
    echo "<pre>";
    print_r(json_decode($result, true));
    echo "</pre>";
}
?>
