<?php
// Database connection details
$servername = "sql311.infinityfree.com";
$username = "if0_39901531";
$password = "DT27M3kCCvPAS"; // <-- Yahan InfinityFree ka main password daalo
$dbname = "if0_39901531_Rahul";

// Connection banao
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Connection check karo
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>