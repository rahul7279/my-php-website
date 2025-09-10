<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="info-section">
            <h1>Welcome Back!</h1>
            <p>Enter your details to login and continue your journey with us.</p>
        </div>
        <div class="form-section">
            <h2>User Login</h2>
            
            <form action="login.php" method="post">
                <?php
                    if (isset($_GET['signup']) && $_GET['signup'] == 'success') {
                        echo '<p class="message success">Signup successful! Please login.</p>';
                    }
                    if (isset($_GET['error'])) {
                        echo '<p class="message error">Invalid email or password!</p>';
                    }
                ?>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <div class="form-footer">
                <a href="forgot_password.php" style="display: block; margin-bottom: 15px;">Forgot Password?</a>
                <p>Don't have an account? <a href="signup.php">Sign Up here</a></p>
            </div>
        </div>
    </div>
</body>
</html>