<?php
// Enhanced Debugging API
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

require_once 'cors.php';

$message = $_GET['q'] ?? $_GET['message'] ?? 'Hello';
$context = $_GET['c'] ?? 'Debug';

$apiKey = "AIzaSyC70RuVvyOq7rCBqhqlmqV1Lhj_g-mnETI"; 
// Try a fallback model if 2.0 fails
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=" . $apiKey;

$data = [
    "contents" => [
        [
            "role" => "user",
            "parts" => [["text" => "Context: $context. User says: $message"]]
        ]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

// DEBUG OUTPUT
if ($curlError) {
    echo json_encode(["status" => "error", "message" => "CURL Error: $curlError"]);
} else {
    $json = json_decode($response, true);
    if (isset($json['candidates'])) {
        echo json_encode(["status" => "success", "reply" => $json['candidates'][0]['content']['parts'][0]['text']]);
    } else {
        // Show the raw Google Error
        echo json_encode(["status" => "api_fail", "code" => $httpCode, "raw" => $json]);
    }
}
?>
