<?php
session_start();
include 'db_connect.php';

// Check admin access
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../../login.php");
    exit;
}

// Check form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get category data
    $name = trim($_POST['category_name']);
    $description = trim($_POST['description']);

    // Check duplicate category
    $check = $conn->prepare("SELECT id FROM categories WHERE name = ?");
    $check->bind_param("s", $name);
    $check->execute();
    $check->store_result();

    // Redirect if category exists
    if ($check->num_rows > 0) {
        header("Location: ../pages/admin/categories.php?error=exists");
        exit;
    }

    // Insert new category
    $stmt = $conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $description);

    // Redirect if successful
    if ($stmt->execute()) {
        header("Location: ../pages/admin/categories.php?success=added");
        exit;
    }
}
?>