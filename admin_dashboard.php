<?php
session_start();
require 'db_connect.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Data Fetching
$all_users_result = mysqli_query($conn, "SELECT id, name, email, role FROM users");
$sales_result = mysqli_query($conn, "SELECT id, brand_name, model_name, units_sold, sale_date FROM phone_sales ORDER BY sale_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body data-theme="dark">
    <div class="dashboard-container" style="max-width: 1200px;">
        <header class="dashboard-header">
            <a href="logout.php" class="logout-btn">Logout</a>
            <h1>Admin Panel</h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> (Admin)!</p>
        </header>

        <header class="dashboard-header">
            </header>

        <?php
            if (isset($_GET['update_user']) && $_GET['update_user'] == 'success') {
                echo '<p style="color: green; font-weight: bold; text-align: center; margin-bottom: 20px;">User details updated successfully!</p>';
            }
            if (isset($_GET['delete_user']) && $_GET['delete_user'] == 'success') {
                echo '<p style="color: green; font-weight: bold; text-align: center; margin-bottom: 20px;">User deleted successfully!</p>';
            }
        ?>
        <div class="tab-nav">

        <div class="tab-nav">
            <button class="tab-btn active" onclick="openTab(event, 'salesTab')"><i class="fa-solid fa-chart-line"></i> Manage Sales</button>
            <button class="tab-btn" onclick="openTab(event, 'usersTab')"><i class="fa-solid fa-users"></i> Manage Users</button>
        </div>

        <div id="salesTab" class="tab-pane active">
            <div class="form-container">
                <h2><i class="fa-solid fa-plus"></i> Add New Sale Record</h2>
                <form action="handle_add_sale.php" method="post" class="inline-form">
                    <input type="text" name="brand_name" placeholder="Brand Name" required>
                    <input type="text" name="model_name" placeholder="Model Name" required>
                    <input type="number" name="units_sold" placeholder="Units Sold" required>
                    <input type="date" name="sale_date" required>
                    <button type="submit">Add Sale</button>
                </form>
            </div>
            <div class="table-container">
                <h2><i class="fa-solid fa-list"></i> All Sales Records</h2>
                <table>
                    <thead><tr><th>ID</th><th>Brand</th><th>Model</th><th>Units</th><th>Date</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($sales_result)): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['brand_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['model_name']); ?></td>
                                <td><?php echo $row['units_sold']; ?></td>
                                <td><?php echo date('d M, Y', strtotime($row['sale_date'])); ?></td>
                                <td><a href="delete_sale.php?id=<?php echo $row['id']; ?>" class="action-btn delete" onclick="return confirm('Are you sure?');">Delete</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="usersTab" class="tab-pane">
            <div class="table-container">
                <h2><i class="fa-solid fa-users"></i> All Registered Users</h2>
                <table>
                    <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($all_users_result)): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['role']); ?></td>
                                <td>
                                    <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="action-btn edit">Edit</a>
                                    <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="action-btn delete" onclick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        function openTab(evt, tabName) {
            // Saare tab content ko hide karo
            const tabPanes = document.querySelectorAll(".tab-pane");
            tabPanes.forEach(pane => pane.classList.remove("active"));

            // Saare tab buttons se 'active' class hatao
            const tabBtns = document.querySelectorAll(".tab-btn");
            tabBtns.forEach(btn => btn.classList.remove("active"));

            // Current tab ko show karo aur button ko active karo
            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.classList.add("active");
        }
    </script>
</body>
</html>