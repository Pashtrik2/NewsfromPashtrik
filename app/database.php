<?php
// Database configuration for XAMPP (default settings)
$host = "localhost";
$db_name = "newsfrompashtrik"; // Change to your database name
$username = "root";
$password = ""; // Default XAMPP has no password for root

try {
    $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
    die();
}
?>
