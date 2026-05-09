<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in and if the role is admin.
// If not, redirect them to the login page for security.
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../../login.php");
    exit;
}

// Check if the form was submitted using POST method.
// POST is usually used when sending form data securely.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the category name from the form and remove extra spaces.
    // trim() removes unnecessary spaces before and after the text.
    $name = trim($_POST['category_name']);

    // Get the category description and remove extra spaces.
    $description = trim($_POST['description']);

    // Check if a category with the same name already exists in the database.
    // This helps prevent duplicate categories.
    $check = $conn->prepare("SELECT id FROM categories WHERE name = ?");

    // Bind the category name to the SQL query.
    // "s" means the value is a string.
    $check->bind_param("s", $name);

    // Execute the query.
    $check->execute();

    // Store the result so we can count matching rows.
    $check->store_result();

    // If a category already exists, redirect back with an error message.
    if ($check->num_rows > 0) {
        header("Location: ../pages/admin/categories.php?error=exists");
        exit;
    }

    // Prepare an SQL query to insert a new category into the database.
    $stmt = $conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");

    // Bind the values to the SQL query.
    // "ss" means both values are strings.
    $stmt->bind_param("ss", $name, $description);

    // Execute the query to save the category.
    if ($stmt->execute()) {

        // If successful, redirect back to the category page
        // and show a success message in the URL.
        header("Location: ../pages/admin/categories.php?success=added");
        exit;
    }
}
?>