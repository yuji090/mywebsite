<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "mywebsite_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    $_SESSION['username'] = $username;
    header("Location: index.php");
    exit();
}
?>
