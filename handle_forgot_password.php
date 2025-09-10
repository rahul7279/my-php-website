<?php
require 'vendor/autoload.php';
require 'db_connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $token = bin2hex(random_bytes(50));
        $expires = date("Y-m-d H:i:s", time() + 3600); // Token 1 ghante ke liye valid

        $sql_insert = "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt_insert, "sss", $email, $token, $expires);
        mysqli_stmt_execute($stmt_insert);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'pr918120@gmail.com'; // <-- APNA GMAIL YAHA DAALO
            $mail->Password   = 'ugjsubisffvjnnco'; // <-- APNA GMAIL APP PASSWORD YAHA DAALO
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('pr918120@gmail.com', 'Your Project Name');
            $mail->addAddress($email);

            $reset_link = "http://localhost/my_project/reset_password.php?token=$token";
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Click here to reset your password: <a href='$reset_link'>$reset_link</a>";
            $mail->send();
            echo 'Reset link has been sent. Please check your email.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'If your email is in our system, a reset link has been sent.';
    }
}
?>