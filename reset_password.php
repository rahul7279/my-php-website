<!DOCTYPE html>
<html lang="en">
<head>
    <title>Set New Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="max-width: 500px; height: auto;">
        <div class="form-section">
            <h2>Set a New Password</h2>
            <form action="handle_reset_password.php" method="post">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                <div class="input-group">
                    <label>New Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="input-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="password_confirm" required>
                </div>
                <button type="submit">Set New Password</button>
            </form>
        </div>
    </div>
</body>
</html>