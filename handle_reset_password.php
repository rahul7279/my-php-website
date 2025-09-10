<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password !== $password_confirm) { die('Passwords do not match.'); }

    $sql = "SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $email = $row['email'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $update_sql = "UPDATE users SET password = ? WHERE email = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "ss", $hashed_password, $email);
        mysqli_stmt_execute($update_stmt);

        $delete_sql = "DELETE FROM password_resets WHERE email = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_sql);
        mysqli_stmt_bind_param($delete_stmt, "s", $email);
        mysqli_stmt_execute($delete_stmt);

        header('Location: index.php?reset=success');
        exit();
    } else {
        die('Invalid or expired token.');
    }
}
?>