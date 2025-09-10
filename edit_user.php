<?php
session_start();
require 'db_connect.php';

// Security Check: Sirf admin hi is page ko access kar sakta hai
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$userIdToEdit = $_GET['id'];

// Database se uss user ka current data fetch karo
$sql = "SELECT name, email, mobile, role FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $userIdToEdit);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body data-theme="dark">
    <div class="container" style="height: auto; max-width: 500px;">
        <div class="form-section" style="justify-content: center;">
            <h2>Edit User Details</h2>
            
            <form action="handle_update_user.php" method="post">
                <input type="hidden" name="id" value="<?php echo $userIdToEdit; ?>">
                
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
                <div class="input-group">
                    <label>Role</label>
                    <select name="role" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #3a3a3a; background-color: #2a2a2a; color: #e0e0e0;">
                        <option value="user" <?php if($user['role'] == 'user') echo 'selected'; ?>>User</option>
                        <option value="admin" <?php if($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                    </select>
                </div>
                <button type="submit">Save Changes</button>
            </form>

            <div class="form-footer">
                <p><a href="admin_dashboard.php">Back to Admin Panel</a></p>
            </div>
        </div>
    </div>
</body>
</html>