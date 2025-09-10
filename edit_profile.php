<?php
session_start();
require 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$userId = $_SESSION['user_id'];

// Database se user ka current data fetch karo
$sql = "SELECT name, email, mobile FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body data-theme="<?php echo htmlspecialchars($_SESSION['user_theme'] ?? 'light'); ?>">
    <div class="container">
        <div class="form-section" style="justify-content: center;">
            <h2>Update Your Details</h2>
            
            <form action="handle_update_profile.php" method="post">
                <div class="input-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>
                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="input-group">
                    <label>Mobile Number</label>
                    <input type="text" name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" required>
                </div>
                <button type="submit">Save Changes</button>
            </form>

            <div class="form-footer">
                <p><a href="dashboard.php">Back to Dashboard</a></p>
            </div>
        </div>
    </div>
</body>
</html>