<?php
session_start();
require 'db_connect.php';

// Security Check: Sirf admin hi delete kar sakta hai
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Admin ko khud ko delete karne se roko
if ($_GET['id'] == $_SESSION['user_id']) {
    header("Location: admin_dashboard.php?error=self_delete");
    exit();
}

$userIdToDelete = $_GET['id'];

// Database se user ko delete karo
$sql = "DELETE FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $userIdToDelete);

if (mysqli_stmt_execute($stmt)) {
    header("Location: admin_dashboard.php?delete_user=success");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>