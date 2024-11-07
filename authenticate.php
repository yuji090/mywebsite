<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "your_database_name");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();

    if (password_verify($password, $hashedPassword)) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        echo "Invalid credentials";
    }
}
?>
