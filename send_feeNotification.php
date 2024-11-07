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

// Check if user_id is set in POST request
if (isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']); // Sanitize the user ID

    try {
        // Create a new PDO instance for the database connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve user email based on user_id
        $sql = "SELECT email FROM users WHERE id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $recipient_email = $user['email'];

            // Prepare to send email
            $mail = new PHPMailer(true);
            $subject = "Payment Reminder";
            $email_message = "This is a reminder to pay your membership fee.";

            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bishtakhil04@gmail.com'; // Your Gmail address
            $mail->Password = 'lccl unjo lfnz gukj';     // Your Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Set email format and recipient
            $mail->setFrom('bishtakhil04@gmail.com', 'My Website'); // Your Gmail address
            $mail->addAddress($recipient_email); // Recipient email address
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $email_message;

            // Send email notification
            $mail->send();
            echo "Notification sent successfully!";
        } else {
            echo "User not found.";
        }
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    } finally {
        // Close the database connection
        $conn = null;
    }
} else {
    echo "No user ID provided.";
}
?>
