<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');
require_once 'db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['user_id']) && isset($data['session_index'])) {
    $user_id = (int)$data['user_id'];
    $session_index = (int)$data['session_index'];
    $is_done = isset($data['is_done']) ? (int)$data['is_done'] : 0;
    
    // UPSERT assignment status
    $sql = "INSERT INTO user_assignments (user_id, session_index, is_done) 
            VALUES ($user_id, $session_index, $is_done) 
            ON DUPLICATE KEY UPDATE is_done = $is_done";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Missing data"]);
}
?>
