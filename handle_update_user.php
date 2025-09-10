<?php
session_start();
require 'db_connect.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Form se saara data lo
$userIdToUpdate = $_POST['id'];
$newName = $_POST['name'];
$newEmail = $_POST['email'];
$newMobile = $_POST['mobile'];
$newRole = $_POST['role'];

// Database mein details update karo
$sql = "UPDATE users SET name = ?, email = ?, mobile = ?, role = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssssi", $newName, $newEmail, $newMobile, $newRole, $userIdToUpdate);

if (mysqli_stmt_execute($stmt)) {
    // Success message ke saath admin dashboard par wapas bhejo
    header("Location: admin_dashboard.php?update_user=success");
    exit();
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>