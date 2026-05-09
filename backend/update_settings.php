<?php
// Start the session so we can access user data (like login info)
session_start();

// Connect to the database
include 'db_connect.php';


// --------------------------------------------------
// CHECK IF USER IS LOGGED IN AND IS AN ADMIN
// --------------------------------------------------
// If the user is not logged in OR not an admin:
// 1. Remove their session
// 2. Regenerate session ID (for security)
// 3. Redirect them to login page
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    unset($_SESSION['user']); 
    session_regenerate_id(true); 
    header("Location: ../login.php");
    exit;
}


// --------------------------------------------------
// HANDLE ACCOUNT INFORMATION UPDATE
// --------------------------------------------------
// This block runs when the "update account" form is submitted
if (isset($_POST['update_account'])) {

    // Get and clean user inputs (remove extra spaces)
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone_no']);
    $user_id = $_SESSION['user']['id'];

    // Validate phone number format
    // Must start with "09" and have exactly 11 digits total
    if (!preg_match('/^09[0-9]{9}$/', $phone)) {
        header("Location: ../pages/admin/settings.php?error=wrongformat");
        exit;    
    }

    // Prepare a secure SQL query to update account details
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, phone_no = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $phone, $user_id);

    // Execute the query
    if ($stmt->execute()) {

        // Update session values so changes reflect immediately
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['phone_no'] = $phone;

        // Redirect with success message
        header("Location: ../pages/admin/settings.php?success=account");
        exit;

    } else {

        // Redirect with error if update fails
        header("Location: ../pages/admin/settings.php?error=account");
        exit;
    }
}


// --------------------------------------------------
// HANDLE PASSWORD CHANGE
// --------------------------------------------------
// This block runs when the "change password" form is submitted
if (isset($_POST['change_password'])) {

    // Get password inputs from the form
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['user']['id'];

    // Fetch the current hashed password from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if the entered current password is correct
    // password_verify compares plain text with hashed password
    if (!password_verify($current_password, $user['password'])) {
        header("Location: ../pages/admin/settings.php?error=wrong_password");
        exit;
    }

    // Check if new password and confirm password match
    if ($new_password !== $confirm_password) {
        header("Location: ../pages/admin/settings.php?error=password_mismatch");
        exit;
    }

    // Check if new password is at least 8 characters long
    if (strlen($new_password) < 8) {
        header("Location: ../pages/admin/settings.php?error=password_short");
        exit;
    }

    // Hash the new password for security before storing it
    $hashed = password_hash($new_password, PASSWORD_ARGON2I);

    // Prepare query to update password
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed, $user_id);

    // Execute the update
    if ($stmt->execute()) {

        // Redirect with success message
        header("Location: ../pages/admin/settings.php?success=password");
        exit;

    } else {

        // Redirect with error if update fails
        header("Location: ../pages/admin/settings.php?error=password");
        exit;
    }
}
?>