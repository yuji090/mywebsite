<?php
session_start();
require 'db.php';

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role']; // Either 'member' or 'admin'

    // Insert new user into the `users` table
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);

    if ($stmt->execute()) {
        echo "<p class='success'>New user added successfully.</p>";
    } else {
        echo "<p class='error'>Error adding user: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('/mywebsite/resources/background1.jpg');
        }

        h1 {
            font-size: 2rem;
            color: #4e5d6c;
            text-align: center;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 500px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            font-size: 1rem;
            color: #4e5d6c;
        }

        input, select {
            padding: 10px;
            font-size: 1rem;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 12px;
            font-size: 1.1rem;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #4cae4c;
        }

        .success {
            color: green;
            font-size: 1.2rem;
            text-align: center;
        }

        .error {
            color: red;
            font-size: 1.2rem;
            text-align: center;
        }

        a {
            display: block;
            text-align: center;
            font-size: 1rem;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New User</h1>
        <form action="admin_add_user.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="member">Member</option>
                <option value="admin">Admin</option>
            </select>
            
            <button type="submit">Add User</button>
        </form>
        <br>
        <a href="ak.php">Go back</a>
    </div>
</body>
</html>
