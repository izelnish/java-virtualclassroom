<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');
require_once 'cors.php';
require_once 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['email']) && isset($data['password']) && isset($data['name']) && isset($data['role'])) {
    $name = $conn->real_escape_string($data['name']);
    $email = $conn->real_escape_string($data['email']);
    $role = $conn->real_escape_string($data['role']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode([
            "success" => true, 
            "message" => "Registration successful",
            "id" => $conn->insert_id,
            "name" => $name,
            "role" => $role
        ]);
    } else {
        if ($conn->errno == 1062) {
            echo json_encode(["success" => false, "message" => "Email already exists"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid input data"]);
}
?>
