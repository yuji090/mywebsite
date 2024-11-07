<?php
$conn = new mysqli("localhost", "root", "root", "mywebsite_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = $_POST['member_id'];

    // Get the current fee status
    $query = "SELECT fee FROM member_details WHERE member_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $stmt->bind_result($current_fee);
    $stmt->fetch();
    $stmt->close();

    // Toggle the fee status
    $new_fee = ($current_fee === 'paid') ? 'unpaid' : 'paid';

    // Update the fee status in the database
    $update_query = "UPDATE member_details SET fee = ? WHERE member_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $new_fee, $member_id);
    $stmt->execute();
    $stmt->close();

    // Return the new fee status as the response
    echo $new_fee;
}
?>
