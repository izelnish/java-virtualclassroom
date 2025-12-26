<?php
// List Available Gemini Models
error_reporting(E_ALL);
ini_set('display_errors', 1);

$apiKey = "AIzaSyC70RuVvyOq7rCBqhqlmqV1Lhj_g-mnETI"; 
$url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "CURL Error: $error";
} else {
    $json = json_decode($response, true);
    if (isset($json['models'])) {
        echo "<h1>Available Models:</h1><ul>";
        foreach ($json['models'] as $m) {
            // Filter for models that support 'generateContent'
            if (in_array("generateContent", $m['supportedGenerationMethods'])) {
                echo "<li><strong>" . $m['name'] . "</strong><br>Display: " . $m['displayName'] . "</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<h1>Error Fetching Models:</h1>";
        echo "<pre>"; print_r($json); echo "</pre>";
    }
}
?>
