<?php
session_start();
include 'db_connect.php';

// Check admin access
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../../login.php");
    exit;
}

// Get category ID
$id = $_GET['id'];

// Check linked products
$check = $conn->prepare("SELECT COUNT(*) as total FROM products WHERE category_id = ?");
$check->bind_param("i", $id);
$check->execute();

// Get result
$result = $check->get_result();
$row = $result->fetch_assoc();

// Stop if category has products
if ($row['total'] > 0) {
    header("Location: ../pages/admin/categories.php?error=has_products");
    exit;
}

// Delete category
$stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);

// Execute delete
if ($stmt->execute()) {
    header("Location: ../pages/admin/categories.php?success=deleted");
    exit;
}
?>