<?php
session_start();
require 'db.php'; // Include the database connection file

// Redirect to login if the user is not signed in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get height and weight from the form
    $height = $_POST['height'];
    $weight = $_POST['weight'];

    // Prepare the update statement
    $stmt = $conn->prepare("UPDATE user_details SET height = ?, weight = ? WHERE user_id = ?");
    $stmt->bind_param("ddi", $height, $weight, $user_id);

    // Execute the update
    if ($stmt->execute()) {
        // Redirect back to the home page with a success message
        $_SESSION['message'] = "Details updated successfully!";
    } else {
        // Handle the error
        $_SESSION['message'] = "Error updating details. Please try again.";
    }

    $stmt->close();
}

// Redirect to home page
header("Location: index.php");
exit();
?>
