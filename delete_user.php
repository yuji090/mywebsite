<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['member_id'])) {
    $member_id = $_POST['member_id'];

    // Start a transaction to ensure both deletions occur together
    $conn->begin_transaction();

    try {
        // Retrieve the user_id associated with the member
        $stmt = $conn->prepare("SELECT user_id FROM member_details WHERE member_id = ?");
        $stmt->bind_param("i", $member_id);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();

        // Delete from member_details
        $stmt = $conn->prepare("DELETE FROM member_details WHERE member_id = ?");
        $stmt->bind_param("i", $member_id);
        $stmt->execute();
        $stmt->close();

        // Delete from users if user_id was found
        if ($user_id) {
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();
        }

        // Commit the transaction
        $conn->commit();
        echo "success";
    } catch (Exception $e) {
        // Roll back the transaction on error
        $conn->rollback();
        echo "error";
    }
}

$conn->close();
?>
