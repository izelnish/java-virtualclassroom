<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');
require_once 'cors.php';
require_once 'db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['user_id']) && isset($data['session_index'])) {
    $user_id = (int)$data['user_id'];
    $session_index = (int)$data['session_index'];
    $is_completed = isset($data['is_completed']) ? (int)$data['is_completed'] : 0;
    
    // UPSERT progress
    $sql = "INSERT INTO user_progress (user_id, session_index, is_completed) 
            VALUES ($user_id, $session_index, $is_completed) 
            ON DUPLICATE KEY UPDATE is_completed = $is_completed";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Missing data"]);
}
?>
