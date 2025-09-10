<?php
session_start();
require 'db_connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($user = mysqli_fetch_assoc($result)) {
    if (password_verify($password, $user['password'])) {
        // Password sahi hai, saari details session mein store karo
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name']; 
        $_SESSION['user_theme'] = $user['theme'];
        $_SESSION['user_role'] = $user['role']; // Humne role bhi session mein daal diya

        // Ab role check karo
        if ($user['role'] === 'admin') {
            // Agar user admin hai, toh admin_dashboard.php par bhejo
            header("Location: admin_dashboard.php");
        } else {
            // Agar normal user hai, toh normal dashboard par bhejo
            header("Location: dashboard.php");
        }
        exit();
    }
}

header("Location: index.php?error=1");
exit();
?>