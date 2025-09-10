<?php
session_start();
require 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Form se data lo
$newName = $_POST['name'];
$newEmail = $_POST['email'];
$newMobile = $_POST['mobile'];
$userId = $_SESSION['user_id'];

// Database mein details update karo
$sql = "UPDATE users SET name = ?, email = ?, mobile = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssi", $newName, $newEmail, $newMobile, $userId);

if (mysqli_stmt_execute($stmt)) {
    // Session mein bhi naya naam update karo taaki dashboard par turant dikhe
    $_SESSION['user_name'] = $newName;
    
    // Success message ke saath dashboard par wapas bhejo
    header("Location: dashboard.php?update=success");
    exit();
} else {
    // Agar koi error aaya
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>