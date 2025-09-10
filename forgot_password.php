<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="max-width: 500px; height: auto;">
        <div class="form-section">
            <h2>Reset Password</h2>
            <p style="text-align: center; margin-bottom: 20px;">Enter your email address and we will send you a link to reset your password.</p>
            <form action="handle_forgot_password.php" method="post">
                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>
                <button type="submit">Send Reset Link</button>
            </form>
            <div class="form-footer">
                <p><a href="index.php">Back to Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>