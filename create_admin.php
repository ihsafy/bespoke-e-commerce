<?php
require_once 'includes/db.php';

// Define the credentials
$full_name = 'System Admin';
$email = 'admin@roraluxe.com';
$password = 'admin123'; 

// Create a fresh hash using YOUR server's PHP settings
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if admin already exists, if so, update them. Otherwise, insert them.
$check = $conn->query("SELECT id FROM users WHERE email = '$email'");

if ($check->num_rows > 0) {
    $sql = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
    $action = "updated";
} else {
    $sql = "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$hashed_password')";
    $action = "created";
}

if ($conn->query($sql)) {
    echo "<h2>Success! Admin account $action.</h2>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Password:</strong> $password</p>";
    echo "<br><a href='admin/login.php'>Go to Admin Login</a>";
} else {
    echo "Error: " . $conn->error;
}
?>