<?php

// Database settings
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "hardware_store";

// Connect to database
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Count total customers
$totalUsersResult = $conn->query(
    "SELECT COUNT(*) as total 
     FROM users 
     WHERE role = 'customer'"
);

// Get customer count
$totalUsers = $totalUsersResult->fetch_assoc()['total'];

// Get monthly revenue
$rev_result = $conn->query(
    "SELECT SUM(total_amount) as total 
     FROM orders 
     WHERE MONTH(order_date) = MONTH(CURDATE()) 
     AND YEAR(order_date) = YEAR(CURDATE()) 
     AND order_status = 'completed'"
);

// Format revenue
$totalRevenue = "₱" . number_format(
    $rev_result->fetch_assoc()['total'] ?? 0,
    2
);

// Count total orders
$ord_result = $conn->query(
    "SELECT COUNT(*) as total 
     FROM orders"
);

// Get order count
$totalOrders = $ord_result->fetch_assoc()['total'];

// Get average order value
$avg_result = $conn->query(
    "SELECT AVG(total_amount) as average 
     FROM orders"
);

// Format average value
$AvgOV = "₱" . number_format(
    $avg_result->fetch_assoc()['average'] ?? 0,
    2
);

?>