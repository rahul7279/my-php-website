<?php
session_start();
require 'db_connect.php';

// Check karo ki user logged-in hai ya nahi
if (!isset($_SESSION['user_id'])) {
    exit('User not logged in');
}

// JavaScript se bheji hui theme lo
$data = json_decode(file_get_contents('php://input'), true);
$theme = $data['theme'];
$userId = $_SESSION['user_id'];

// Database mein theme update karo
$sql = "UPDATE users SET theme = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "si", $theme, $userId);

if (mysqli_stmt_execute($stmt)) {
    // Session mein bhi theme update karo
    $_SESSION['user_theme'] = $theme;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

mysqli_close($conn);
?>