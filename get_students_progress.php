<?php
header('Content-Type: application/json');
require_once 'cors.php';
require_once 'db.php';

// Ensure only staff can access this (in a real app, check session/token)
// For this demo, we assume the frontend handles the "Staff" view visibility

try {
    $sql = "SELECT 
                u.id, 
                u.name, 
                u.email, 
                u.created_at,
                COUNT(up.session_index) as completed_count 
            FROM users u
            LEFT JOIN user_progress up ON u.id = up.user_id AND up.is_completed = 1
            WHERE u.role = 'student'
            GROUP BY u.id
            ORDER BY u.created_at DESC";

    $result = $conn->query($sql);
    
    $students = [];
    $total_sessions = 12; // Matches our curriculum

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Format date
            $date = new DateTime($row['created_at']);
            $formattedDate = $date->format('M d, Y');

            // Calculate progress percentage
            $progress = round(($row['completed_count'] / $total_sessions) * 100);

            $students[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'enrolled' => $formattedDate,
                'progress' => $progress,
                'completed_count' => $row['completed_count']
            ];
        }
    }

    echo json_encode(['success' => true, 'students' => $students]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>
