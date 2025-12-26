<?php
header('Content-Type: application/json');

// Your Key
$apiKey = "AIzaSyC70RuVvyOq7rCBqhqlmqV1Lhj_g-mnETI"; 

$url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['error' => curl_error($ch)]);
} else {
    echo $response;
}

curl_close($ch);
?>
