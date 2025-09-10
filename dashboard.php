<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body data-theme="<?php echo htmlspecialchars($_SESSION['user_theme'] ?? 'light'); ?>">
    <div class="dashboard-container">
        <header class="dashboard-header">
            <a href="logout.php" class="logout-btn">Logout</a>
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
            <p>Select an option below to get started.</p>

            <div class="theme-switcher">
                <button class="theme-btn" data-theme="light" title="Light Theme"></button>
                <button class="theme-btn" data-theme="dark" title="Dark Theme"></button>
                <button class="theme-btn" data-theme="ocean" title="Ocean Theme"></button>
                <button class="theme-btn" data-theme="forest" title="Forest Theme"></button>
                
                <label for="bg-upload" class="theme-btn custom-bg-btn" title="Upload Your Image">
                    <i class="fa-solid fa-upload"></i>
                </label>
                <input type="file" id="bg-upload" accept="image/*" style="display: none;">
            </div>
        </header>

        <?php
            if (isset($_GET['update']) && $_GET['update'] == 'success') {
                echo '<p style="color: green; font-weight: bold; text-align: center; margin-bottom: 20px;">Profile updated successfully!</p>';
            }
        ?>

        <div class="options-grid">
            <a href="https://rahul7279-fake-newsdetecter-image-text--app-ophk3e.streamlit.app/" class="option-card">
                <i class="fa-solid fa-robot"></i>
                <h2>AI Model</h2>
                <p>Interact with our custom AI model.</p>
            </a>

            <a href="sales_dashboard.php" class="option-card">
                <i class="fa-solid fa-chart-line"></i>
                <h2>Sales Data</h2>
                <p>View and filter sales reports.</p>
            </a>

            <a href="https://soulphotography12.blogspot.com/?m=1" class="option-card">
                <i class="fa-solid fa-camera-retro"></i>
                <h2>My Photography</h2>
                <p>Check out my latest photos and clicks.</p>
            </a>

            <a href="https://www.instagram.com/sou.lphotography?igsh=cjdoaTgzbjFjdHpp" class="option-card">
                <i class="fa-brands fa-instagram"></i>
                <h2>Instagram</h2>
                <p>Follow our creator channel.</p>
            </a>
            
            <a href="edit_profile.php" class="option-card">
                <i class="fa-solid fa-user-pen"></i>
                <h2>Edit Profile</h2>
                <p>Update your personal details.</p>
            </a>
        </div>
    </div>

    <script>
        const themeButtons = document.querySelectorAll('.theme-btn');
        const bgUploadInput = document.getElementById('bg-upload');
        
        const setTheme = (theme) => {
            document.body.style.backgroundImage = '';
            document.body.dataset.theme = theme;
            updateThemeInDB(theme);
        };

        const setCustomBg = (imageData) => {
            document.body.style.backgroundImage = `url(${imageData})`;
            document.body.dataset.theme = 'custom';
        };
        
        const updateThemeInDB = (theme) => {
            fetch('update_theme.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ theme: theme })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) { console.error('Failed to save theme.'); }
            });
        };

        themeButtons.forEach(button => {
            button.addEventListener('click', () => {
                const theme = button.dataset.theme;
                setTheme(theme);
            });
        });

        // NOTE: User-uploaded backgrounds are not saved in the database in this version.
        bgUploadInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                const imageData = reader.result;
                setCustomBg(imageData);
            };
        });
    </script>
</body>
</html>