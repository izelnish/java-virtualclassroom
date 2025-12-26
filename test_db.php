<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Connection Test</h1>";

require 'db_connect.php';

if ($conn->ping()) {
    echo "<h3 style='color:green'>Database Connected Successfully!</h3>";
    echo "Host: " . $host . "<br>";
    echo "User: " . $username . "<br>";
} else {
    echo "<h3 style='color:red'>Connection Failed!</h3>";
    echo "Error: " . $conn->error;
}
?>
