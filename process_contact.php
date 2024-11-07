<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    // In a real application, save to a database or send an email
    echo "<p>Thank you, $name! We have received your message.</p>";
} else {
    header("Location: contact.php");
    exit();
}
?>
