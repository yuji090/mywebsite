<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "mywebsite_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the query to get user details
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashedPassword, $role);
    $stmt->fetch();
    $stmt->close();

    // Verify password and set session data
    if (password_verify($password, $hashedPassword)) {
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;

        // Redirect based on the user's role
        if ($role === 'admin') {
            header("Location: ak.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        echo "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
     body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-image: url('/mywebsite/resources/background.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    color: #f3f3f3;
    box-sizing: border-box;
    background-color : #060000;
}

form {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 30px;
    width: 300px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    gap: 15px;
}

label {
    font-size: 1.1em;
    margin-bottom: 5px;
}

input {
    padding: 10px;
    border: none;
    border-radius: 10px;
    outline: none;
    font-size: 1em;
    transition: border 0.3s ease;
}

input:focus {
    border: 2px solid #4CAF50; /* Change the border color when focused */
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #45a049; /* Darker green on hover */
}

p {
    margin-top: 20px;
}

a {
    color: #4CAF50; /* Link color */
    text-decoration: none;
    transition: color 0.3s ease;
}

a:hover {
    color: #45a049; /* Darker green on hover */
}


    </style>
</head>
<body>
    <form action="login.php" method="post">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="contact.php">Contact Us</a></p>
</body>
</html>
