<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');
require_once 'cors.php';
require_once 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['email']) && isset($data['password'])) {
    $email = $conn->real_escape_string($data['email']);
    $password = $data['password'];

    $sql = "SELECT id, name, password, role FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo json_encode([
                "success" => true,
                "message" => "Login successful",
                "id" => $user['id'],
                "name" => $user['name'],
                "role" => $user['role']
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Invalid password"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "User not found"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid input data"]);
}
?>
