<?php
session_start();
require 'db.php'; // Include the database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$age = $_POST['age'];
$height = $_POST['height'];
$weight = $_POST['weight'];

// Insert user details into the user_details table
$stmt = $conn->prepare("INSERT INTO user_details (user_id, height, weight, age) VALUES (?, ?, ?, ?)");
$stmt->bind_param("idii", $user_id, $height, $weight, $age);

if ($stmt->execute()) {
    header("Location: index.php");
    exit();
} else {
    echo "Error saving details.";
}

$stmt->close();
$conn->close();
?>
