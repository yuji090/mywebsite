<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "mywebsite_db");

// Check for database connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch members data
$query = "SELECT member_id, user_id, name, fee FROM member_details";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);  // This will help diagnose query errors
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Details</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        /* CSS styling as provided */
        body {
            font-family: Arial, sans-serif;
            background-image: url('/mywebsite/resources/background1.jpg');
            background-color: #f4f7fa;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #4a90e2;
            font-size: 2.2em;
            margin-bottom: 20px;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            overflow: hidden;
            border-radius: 10px;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #4a90e2;
            color: #fff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f4f7fa;
        }

        tr:hover {
            background-color: #e6f2ff;
        }

        button {
            padding: 8px 15px;
            font-size: 0.9em;
            color: #fff;
            background-color: #4a90e2;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #357abd;
        }

        @media (max-width: 768px) {
            table {
                width: 100%;
            }

            th, td {
                padding: 10px;
            }
        }
        .ak{
            padding: 8px 15px;
            font-size: 0.9em;
            color: #fff;
            background-color: #4a90e2;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <br>
    <br>
    <h1>Member Details</h1>
    <table border="1">
        <tr>
            <th>Member ID</th>
            <th>Name</th>
            <th>Fee Status</th>
            <th>Action</th>
            <th>Delete</th>
            <th>Send Notification</th>
        </tr>
        <?php 
        if ($result->num_rows > 0): 
            while($row = $result->fetch_assoc()): 
        ?>
        <tr>
            <td><?php echo $row['member_id']; ?></td>
            
            <td><?php echo $row['name']; ?></td>
            <td id="fee-status-<?php echo $row['member_id']; ?>"><?php echo $row['fee']; ?></td>
            <td>
                <button onclick="toggleFee(<?php echo $row['member_id']; ?>)">Toggle Fee</button>
                
            </td>
            <td>
            <button onclick="deleteUser(<?php echo $row['member_id']; ?>)">Delete</button>
            </td>
            <td>
        <button onclick="sendNotification(<?php echo $row['user_id']; ?>)">Notify</button>
            </td>
        </tr>
        <?php 
            endwhile; 
        else: 
        ?>
        <tr>
            <td colspan="5">No members found</td>
        </tr>
        <?php endif; ?>
    </table>

    <script>

        function sendNotification(userId) {
        $.ajax({
            url: 'send_FeeNotification.php',
            type: 'POST',
            data: { user_id: userId },
            success: function(response) {
                alert(response);
            },
            error: function() {
                alert("Error sending notification.");
            }
        });
    }

        function toggleFee(memberId) {
            $.ajax({
                url: 'toggle_fee.php',
                type: 'POST',
                data: { member_id: memberId },
                success: function(response) {
                    $('#fee-status-' + memberId).text(response);
                },
                error: function() {
                    alert('Error toggling fee status.');
                }
            });
        }

        function deleteUser(memberId) {
            if (confirm("Are you sure you want to delete this user?")) {
                $.ajax({
                    url: 'delete_user.php',
                    type: 'POST',
                    data: { member_id: memberId },
                    success: function(response) {
                        if (response === "success") {
                            alert("User deleted successfully.");
                            location.reload();
                        } else {
                            alert("Error deleting user.");
                        }
                    },
                    error: function() {
                        alert("Error deleting user.");
                    }
                });
            }
        }

    </script>
    <br>
    <br>
    <a class="ak" href="admin_add_user.php">Add New Member</a>
    <br>
    <br>
    <a class ="ak" href="logout.php">Logout</a>
</body>
</html>
