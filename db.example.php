<?php
// RENAME THIS FILE TO db.php AND ENTER YOUR DETAILS
error_reporting(0);
ini_set('display_errors', 0);

$host = "YOUR_HOST_HERE"; // e.g., sql300.infinityfree.com
$port = 3306;
$username = "YOUR_USER_HERE";
$password = "YOUR_PASSWORD_HERE";
$dbname = "YOUR_DB_NAME_HERE";

// Create connection
try {
    $conn = new mysqli($host, $username, $password, $dbname, $port);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Could not connect to MySQL: " . $e->getMessage()]);
    exit;
}
?>
