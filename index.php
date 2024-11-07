<?php
session_start();
require 'db.php';

// Redirect to login if user is not signed in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is an admin
if ($_SESSION['role'] === 'admin') {
    header("Location: ak.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user details if they exist (only for members)
$stmt = $conn->prepare("SELECT height, weight, age FROM user_details WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($height, $weight, $age);

// Function to calculate BMI
function calculateBMI($weight, $height) {
    return round($weight / (($height / 100) ** 2), 2);
}

// Check if details exist
if ($stmt->fetch()) {
    // Details exist, calculate BMI
    $bmi = calculateBMI($weight, $height);
    $details_exist = true;
} else {
    // Details do not exist
    $details_exist = false;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - My Website</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function toggleEditForm() {
            const editForm = document.getElementById('editForm');
            if (editForm.style.display === 'none' || editForm.style.display === '') {
                editForm.style.display = 'block';
            } else {
                editForm.style.display = 'none';
            }
        }
    </script>
    <style>
        body {
            background-color :#060000;
        }
        </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <main>
        <section class="user-details">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <?php if ($details_exist): ?>
                <!-- Show user details and BMI if data exists -->
                <p><strong>Age:</strong> <?php echo $age; ?> years</p>
                <p><strong>Height:</strong> <?php echo $height; ?> cm</p>
                <p><strong>Weight:</strong> <?php echo $weight; ?> kg</p>
                <p><strong>BMI:</strong> <?php echo $bmi; ?></p>

                <!-- Edit button to show/hide the update details form -->
                <button onclick="toggleEditForm()" class="edit-btn">Edit Details</button>
                
                <!-- Update details form, initially hidden -->
                <div id="editForm" style="display: none;">
                    <form action="update_details.php" method="POST" style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                        <label for="height">Edit Height (cm):</label>
                        <input type="number" id="height" name="height" value="<?php echo $height; ?>" required>
                        
                        <label for="weight">Edit Weight (kg):</label>
                        <input type="number" id="weight" name="weight" value="<?php echo $weight; ?>" required>
                        
                        <button type="submit" class="update-btn">Update Details</button>
                    </form>
                </div>
            <?php else: ?>
                <!-- Show form if details don't exist -->
                <form action="save_details.php" method="POST">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" required>
                    
                    <label for="height">Height (cm):</label>
                    <input type="number" id="height" name="height" required>
                    
                    <label for="weight">Weight (kg):</label>
                    <input type="number" id="weight" name="weight" required>
                    
                    <button type="submit">Save Details</button>
                </form>
            <?php endif; ?>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
