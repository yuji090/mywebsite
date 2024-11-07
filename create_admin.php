<?php
require 'db.php'; // Make sure to include your database connection

// Admin credentials
$username = 'Akhil';
$email = 'bishtakhil04@gmail.com';
$password = 'Activa@08'; // Change this to your desired password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$role = 'admin';

// Check if an admin already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Admin user already exists.";
} else {
    // Insert new admin user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);

    if ($stmt->execute()) {
        echo "Admin user created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
