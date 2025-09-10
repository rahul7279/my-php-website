<?php
session_start();
require 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$timeframe = $_POST['timeframe'] ?? 'all'; // Default timeframe 'all' hai
$whereClause = '';

// User ke selection ke hisaab se SQL query ka WHERE clause banao
switch ($timeframe) {
    case 'day':
        $whereClause = "WHERE DATE(sale_date) = CURDATE()";
        break;
    case 'week':
        $whereClause = "WHERE YEARWEEK(sale_date, 1) = YEARWEEK(CURDATE(), 1)";
        break;
    case 'month':
        $whereClause = "WHERE MONTH(sale_date) = MONTH(CURDATE()) AND YEAR(sale_date) = YEAR(CURDATE())";
        break;
    case 'year':
        $whereClause = "WHERE YEAR(sale_date) = YEAR(CURDATE())";
        break;
    case 'all':
    default:
        $whereClause = ""; // Koi filter nahi
        break;
}

// Har brand ke total sales ko count karne ki query
$sql = "SELECT brand_name, SUM(units_sold) as total_units FROM phone_sales $whereClause GROUP BY brand_name ORDER BY total_units DESC";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sales Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body data-theme="<?php echo htmlspecialchars($_SESSION['user_theme'] ?? 'light'); ?>">
    <div class="dashboard-container">
        <header class="dashboard-header">
            <a href="dashboard.php" class="logout-btn" style="right: 120px;">Back</a>
            <a href="logout.php" class="logout-btn">Logout</a>
            <h1>Sales Dashboard</h1>
            <p>Check total phone units sold by brand.</p>
        </header>

        <form method="post" action="sales_dashboard.php" style="margin-bottom: 30px;">
            <label for="timeframe" style="font-weight: bold;">Select Timeframe:</label>
            <select name="timeframe" id="timeframe" style="padding: 8px; border-radius: 5px;">
                <option value="all" <?php if ($timeframe == 'all') echo 'selected'; ?>>All Time</option>
                <option value="day" <?php if ($timeframe == 'day') echo 'selected'; ?>>Today</option>
                <option value="week" <?php if ($timeframe == 'week') echo 'selected'; ?>>This Week</option>
                <option value="month" <?php if ($timeframe == 'month') echo 'selected'; ?>>This Month</option>
                <option value="year" <?php if ($timeframe == 'year') echo 'selected'; ?>>This Year</option>
            </select>
            <button type="submit" style="width: auto; padding: 8px 15px; margin-left: 10px;">Filter</button>
        </form>

        <div style="text-align: left;">
            <table border="1" width="100%" style="border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #333; color: white;">
                        <th style="padding: 10px;">Brand Name</th>
                        <th>Total Units Sold</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td style="padding: 10px;"><?php echo htmlspecialchars($row['brand_name']); ?></td>
                                <td style="text-align: center;"><?php echo $row['total_units']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" style="padding: 10px; text-align: center;">No sales data found for this period.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>