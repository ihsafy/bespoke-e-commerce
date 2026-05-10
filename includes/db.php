<?php
// Database configuration for XAMPP
$host = "localhost";
$user = "root";
$pass = ""; // Default XAMPP password is empty
$dbname = "rora_luxe";

// Enable exception handling for professional error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create a new MySQLi connection object
    $conn = new mysqli($host, $user, $pass, $dbname);
    
    // Set the character set to utf8mb4 for full Unicode support (emojis, special characters)
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    // In a professional environment, we log the error and hide the exact details from the user
    error_log($e->getMessage());
    exit("Database connection failed. Please check your configuration.");
}
?>