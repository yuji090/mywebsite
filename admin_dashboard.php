<?php
session_start();
require 'db.php';

// Check if the user is an admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$stmt = $conn->prepare("SELECT u.username, m.joining_date, m.fee_status FROM users u JOIN member_details m ON u.id = m.user_id WHERE u.role = 'member'");
$stmt->execute();
$stmt->bind_result($username, $joining_date, $fee_status);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Member Details</h1>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Joining Date</th>
                <th>Fee Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($stmt->fetch()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($username); ?></td>
                    <td><?php echo htmlspecialchars($joining_date); ?></td>
                    <td><?php echo htmlspecialchars($fee_status); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
