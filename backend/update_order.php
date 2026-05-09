<?php
// Start the session so we can access user data (like login info and role)
session_start();

// Connect to the database
include 'db_connect.php';


// --------------------------------------------------
// CHECK IF USER IS LOGGED IN AND IS AN ADMIN
// --------------------------------------------------
// This ensures that only logged-in users with the "admin" role
// can access and use this script
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}


// --------------------------------------------------
// HANDLE FORM SUBMISSION (ONLY FOR POST REQUESTS)
// --------------------------------------------------
// This checks if the form was submitted using POST method
// (which is commonly used for sending data securely)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the order ID and new status from the form
    // (int) ensures the order_id is treated as a number
    $order_id = (int)$_POST['order_id'];
    $order_status = $_POST['order_status'];

    // Define the list of allowed order statuses
    // This prevents invalid or unexpected values
    $allowed = ['pending', 'processing', 'completed', 'cancelled'];

    // Check if the submitted status is valid
    // If not, redirect back with an error message
    if (!in_array($order_status, $allowed)) {
        header("Location: ../pages/admin/orders.php?error=invalid_status");
        exit;
    }


    // --------------------------------------------------
    // UPDATE ORDER STATUS IN THE DATABASE
    // --------------------------------------------------
    // Prepare a secure SQL query to update the order status
    // "?" are placeholders to prevent SQL injection
    $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE id = ?");

    // Bind the actual values to the placeholders
    // "si" means: string (status), integer (order_id)
    $stmt->bind_param("si", $order_status, $order_id);

    // Execute the query
    if ($stmt->execute()) {

        // --------------------------------------------------
        // REDIRECT AFTER SUCCESSFUL UPDATE
        // --------------------------------------------------
        // If the request came from the order details page,
        // redirect back there with a success message
        if(isset($_POST['redirect']) && $_POST['redirect'] === 'order_details') {
            header("Location: ../pages/admin/order_details.php?id=$order_id&success=1");
        } else {

            // Otherwise, go back to the orders list page
            header("Location: ../pages/admin/orders.php?success=status_updated");
        }
        exit;
    }
}
?>