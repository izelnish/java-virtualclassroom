<?php
// Template for Database Connection
// Rename this file to db_connect.php and fill in your credentials

$host = "your_host";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "DB Error: " . $conn->connect_error]));
}
?>
