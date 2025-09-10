<?php
session_start();
require 'db_connect.php';

// Security Check: Sirf admin hi data add kar sakta hai
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Form se data lo
$brand = $_POST['brand_name'];
$model = $_POST['model_name'];
$units = $_POST['units_sold'];
$date = $_POST['sale_date'];

// Database mein data insert karo
$sql = "INSERT INTO phone_sales (brand_name, model_name, units_sold, sale_date) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssis", $brand, $model, $units, $date);

if (mysqli_stmt_execute($stmt)) {
    // Agar aache se add ho gaya, toh wapas admin dashboard par bhej do
    header("Location: admin_dashboard.php?add=success");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>