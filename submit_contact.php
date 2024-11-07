<?php
// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mywebsite_db";  // Ensure this matches your database name

// Set recipient email for notification
$recipient_email = "bishtakhil04@gmail.com";

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    try {
        // Create a new PDO instance for the database connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert data into the database
        $sql = "INSERT INTO contact_submissions (name, email, message) VALUES (:name, :email, :message)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['name' => $name, 'email' => $email, 'message' => $message]);

        // Prepare to send email
        $mail = new PHPMailer(true);
        $subject = "New Contact Form Submission from $name";
        $email_message = "You have received a new message from the contact form on your website.<br><br>";
        $email_message .= "Name: $name<br>";
        $email_message .= "Email: $email<br>";
        $email_message .= "Message:<br>$message<br>";

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'bishtakhil04@gmail.com'; // Your Gmail address
        $mail->Password = 'lccl unjo lfnz gukj';     // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Set email format and recipient
        $mail->setFrom('your_gmail@gmail.com', 'My Website'); // Your Gmail address
        $mail->addAddress($recipient_email); // Recipient email address
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $email_message;

        // Send email notification
        $mail->send();
        echo "Message sent successfully!";
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    } finally {
        // Close the database connection
        $conn = null;
    }
}
?>
