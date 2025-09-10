<?php
session_start();
require 'db_connect.php';

// Security Check: Sirf admin hi data delete kar sakta hai
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// URL se ID lo
$saleId = $_GET['id'];

// Database se record delete karo
$sql = "DELETE FROM phone_sales WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $saleId);

if (mysqli_stmt_execute($stmt)) {
    // Agar aache se delete ho gaya, toh wapas admin dashboard par bhej do
    header("Location: admin_dashboard.php?delete=success");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>