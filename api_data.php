<?php
// Production Chat API (Valid & Tested)
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'cors.php';
require_once 'db.php';

// Get Input (GET or JSON)
$json = json_decode(file_get_contents('php://input'), true);
$message = $json['message'] ?? $json['q'] ?? $_GET['message'] ?? $_GET['q'] ?? '';
$context = $json['context'] ?? $json['c'] ?? $_GET['context'] ?? $_GET['c'] ?? 'General Java';

if (empty($message)) {
    echo json_encode(['success' => false, 'reply' => "I'm listening..."]);
    exit;
}

// 🤖 CONFIG
$apiKey = "AIzaSyC70RuVvyOq7rCBqhqlmqV1Lhj_g-mnETI"; 
// Using the WORKING model from testing
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=" . $apiKey;

$systemPrompt = "You are a helpful Java Tutor. Context: $context. Keep answers short and simple.";

$data = [
    "contents" => [
        [
            "role" => "user",
            "parts" => [["text" => $systemPrompt . "\nUser: " . $message]]
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

$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$jsonResponse = json_decode($result, true);

if (isset($jsonResponse['candidates'])) {
    $reply = $jsonResponse['candidates'][0]['content']['parts'][0]['text'];
    echo json_encode(['success' => true, 'reply' => $reply]);
} else {
    // If error, show a generic message but LOG it internally if possible
    // For now, we will show the error strictly for debugging if the user asks
    $err = $jsonResponse['error']['message'] ?? "Unknown API Error";
    echo json_encode(['success' => false, 'reply' => "AI Error ($httpCode): $err"]);
}
?>
