<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');
require_once 'cors.php';
require_once 'db.php';

$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

if ($user_id > 0) {
    // Fetch completed sessions
    $progress = [];
    $res1 = $conn->query("SELECT session_index FROM user_progress WHERE user_id = $user_id AND is_completed = 1");
    while($row = $res1->fetch_assoc()) {
        $progress[] = (int)$row['session_index'];
    }

    // Fetch done assignments
    $assignments = [];
    $res2 = $conn->query("SELECT session_index FROM user_assignments WHERE user_id = $user_id AND is_done = 1");
    while($row = $res2->fetch_assoc()) {
        $assignments[] = (int)$row['session_index'];
    }

    echo json_encode([
        "success" => true,
        "completed_sessions" => $progress,
        "done_assignments" => $assignments
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid user ID"]);
}
?>
