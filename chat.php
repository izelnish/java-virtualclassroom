<?php
header('Content-Type: application/json');
require_once 'cors.php';
require_once 'db.php';

// Get Data (Try JSON POST first, then fallback to GET for InfinityFree Bypass)
$json = json_decode(file_get_contents('php://input'), true);
$message = $json['message'] ?? $_GET['message'] ?? '';
$sessionContext = $json['context'] ?? $_GET['context'] ?? 'General Java';

// =================================================================================
// 🤖 AI CONFIGURATION
// =================================================================================
$aiProvider = "gemini"; 
$apiKey = "AIzaSyC70RuVvyOq7rCBqhqlmqV1Lhj_g-mnETI"; // User's Key

if (empty($message)) {
    echo json_encode(['success' => false, 'reply' => "I'm listening... what's on your mind?"]);
    exit;
}

if (empty($apiKey) || $apiKey === "YOUR_KEY_HERE") {
    $reply = "Please paste your API Key in chat.php!";
    echo json_encode(['success' => true, 'reply' => $reply]);
    exit;
}

$apiKey = trim($apiKey); // Safety trim

// System Prompt
$systemPrompt = "You are a helpful Java Tutor. The student is learning: '$sessionContext'. " .
                "Explain concepts simply. Provide short code examples if asked. Keep answers brief.";

try {
    $reply = "";

    // --- GOOGLE GEMINI LOGIC ---
    if ($aiProvider === 'gemini') {
        $apiKey = trim($apiKey); 

        // Strategy: 2.0 Flash (Stable) -> 2.5 Flash (New)
        $modelsToTry = [
            "gemini-2.0-flash", 
            "gemini-2.5-flash"
        ];
        
        $errors = [];

        foreach ($modelsToTry as $model) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=" . $apiKey;
            $payload = [
                "contents" => [
                    [
                        "role" => "user",
                        "parts" => [["text" => $systemPrompt . "\n\nUser Question: " . $message]]
                    ]
                ]
            ];
            
            $response = makeApiRequest($url, $payload);
            
            if (!isset($response['error'])) {
                $reply = $response['candidates'][0]['content']['parts'][0]['text'] ?? "No text returned from $model.";
                break; // Success!
            } else {
                // Collect detailed errors
                $errors[] = "$model: " . ($response['error']['message'] ?? 'Unknown');
            }
        }
        
        // If loop finished without success, show all errors
        if (isset($response['error'])) {
            $reply = "Gemini Failures: " . implode(" | ", $errors);
        }
    } 
    
    // --- OPENAI LOGIC ---
    else {
        $url = 'https://api.openai.com/v1/chat/completions';
        $payload = [
            "model" => "gpt-3.5-turbo",
            "messages" => [
                ["role" => "system", "content" => $systemPrompt],
                ["role" => "user", "content" => $message]
            ],
            "max_tokens" => 200
        ];
        
        $response = makeApiRequest($url, $payload, "Authorization: Bearer " . $apiKey);
        $reply = $response['choices'][0]['message']['content'] ?? "OpenAI Error: " . json_encode($response);
    }

} catch (Exception $e) {
    $reply = "System Error: " . $e->getMessage();
}

echo json_encode(['success' => true, 'reply' => $reply]);

// Helper Function
function makeApiRequest($url, $data, $authHeader = null) {
    $ch = curl_init($url);
    $headers = ["Content-Type: application/json"];
    if ($authHeader) $headers[] = $authHeader;

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // FIX: Disable SSL Verification for XAMPP Localhost
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    // FIX: Force IPv4 (Solves 'Connection was reset' on some Windows setups)
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    
    $result = curl_exec($ch);
    
    if (curl_errno($ch)) throw new Exception("Curl Error: " . curl_error($ch));
    
    curl_close($ch);
    return json_decode($result, true);
}
?>
