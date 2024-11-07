<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "mywebsite_db");

// Fetch members data
$query = "SELECT member_id, user_id, name, fee FROM member_details";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Details</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h1>Member Details</h1>
    <table border="1">
        <tr>
            <th>Member ID</th>
            <th>User ID</th>
            <th>Name</th>
            <th>Fee Status</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['member_id']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td id="fee-status-<?php echo $row['member_id']; ?>"><?php echo $row['fee']; ?></td>
            <td>
                <button onclick="toggleFee(<?php echo $row['member_id']; ?>)">Toggle Fee</button>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <script>
        function toggleFee(memberId) {
            $.ajax({
                url: 'toggle_fee.php',
                type: 'POST',
                data: { member_id: memberId },
                success: function(response) {
                    // Update the fee status in the table based on the response
                    $('#fee-status-' + memberId).text(response);
                },
                error: function() {
                    alert('Error toggling fee status.');
                }
            });
        }
    </script>
</body>
</html>
