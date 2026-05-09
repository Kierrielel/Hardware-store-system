<?php

/*
---------------------------------------------------
DATABASE CONNECTION
---------------------------------------------------
These variables contain the database information
needed to connect PHP to MySQL.

- localhost = database server
- root = default username in Laragon
- "" = empty password
- hardware_store = database name
*/
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "hardware_store";


/*
---------------------------------------------------
CONNECT TO DATABASE
---------------------------------------------------
This creates a connection between PHP
and the MySQL database using mysqli.

Think of this as opening a bridge so
your website can communicate with the database.
*/
$conn = new mysqli($host, $user, $pass, $dbname);


/*
---------------------------------------------------
CHECK DATABASE CONNECTION
---------------------------------------------------
If something goes wrong while connecting,
show an error message and stop the program.

connect_error checks if the connection failed.
*/
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


/*
---------------------------------------------------
GET TOTAL CUSTOMERS
---------------------------------------------------
This counts how many users have the role
of "customer" in the users table.

COUNT(*) counts all matching rows.
"as total" gives the result a readable name.
*/
$totalUsersResult = $conn->query(
    "SELECT COUNT(*) as total 
     FROM users 
     WHERE role = 'customer'"
);

// Fetch the result and store the total count
$totalUsers = $totalUsersResult->fetch_assoc()['total'];


/*
---------------------------------------------------
GET MONTHLY REVENUE
---------------------------------------------------
This calculates the total sales revenue
for the current month.

SUM(total_amount) adds all completed order amounts.

Conditions:
- Same month as today
- Same year as today
- Order must be completed
*/
$rev_result = $conn->query(
    "SELECT SUM(total_amount) as total 
     FROM orders 
     WHERE MONTH(order_date) = MONTH(CURDATE()) 
     AND YEAR(order_date) = YEAR(CURDATE()) 
     AND order_status = 'completed'"
);

/*
Format the revenue:
- number_format() adds commas and decimals
- ?? 0 means use 0 if there is no data
- ₱ adds peso sign
*/
$totalRevenue = "₱" . number_format(
    $rev_result->fetch_assoc()['total'] ?? 0,
    2
);


/*
---------------------------------------------------
GET TOTAL ORDERS
---------------------------------------------------
This counts all orders in the orders table.
*/
$ord_result = $conn->query(
    "SELECT COUNT(*) as total 
     FROM orders"
);

// Get the total number of orders
$totalOrders = $ord_result->fetch_assoc()['total'];


/*
---------------------------------------------------
GET AVERAGE ORDER VALUE
---------------------------------------------------
AVG(total_amount) calculates the average
amount spent per order.

Example:
Orders = 100, 200, 300
Average = 200
*/
$avg_result = $conn->query(
    "SELECT AVG(total_amount) as average 
     FROM orders"
);

/*
Format the average value into Philippine Peso.
?? 0 prevents errors if there are no orders yet.
*/
$AvgOV = "₱" . number_format(
    $avg_result->fetch_assoc()['average'] ?? 0,
    2
);

?>