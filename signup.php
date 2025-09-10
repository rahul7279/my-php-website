<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="info-section">
            <h1>Join Us Today!</h1>
            <p>Create your account to get started. It's free and only takes a minute.</p>
        </div>
        <div class="form-section">
            <h2>Create Account</h2>
            
            <form action="handle_signup.php" method="post">
                <div class="input-group">
                    <label>Full Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>
                <div class="input-group">
                    <label>Mobile Number</label>
                    <input type="text" name="mobile" required>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit">Sign Up</button>
            </form>
            <div class="form-footer">
                 <p>Already have an account? <a href="index.php">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>