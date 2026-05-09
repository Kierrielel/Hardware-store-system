<?php
// Start the session so we can access user data (like login info)
session_start();

// Connect to the database
include 'db_connect.php';


// --------------------------------------------------
// CHECK IF USER IS LOGGED IN AND IS A CUSTOMER
// --------------------------------------------------
// If the user is not logged in OR not a customer:
// 1. Remove their session
// 2. Regenerate session ID (for security)
// 3. Redirect them to login page
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    unset($_SESSION['user']); 
    session_regenerate_id(true); 
    header("Location: ../login.php");
    exit;
}


// --------------------------------------------------
// HANDLE ACCOUNT INFORMATION UPDATE
// --------------------------------------------------
// Runs when the user submits the "update account" form
if (isset($_POST['update_account'])) {

    // Get and clean input values
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone_no']);
    $user_id = $_SESSION['user']['id'];

    // Validate phone number format (must start with 09 and be 11 digits)
    if (!preg_match('/^09[0-9]{9}$/', $phone)) {
        header("Location: ../pages/customer/edit_user.php?error=wrongformat");
        exit;    
    }

    // Prepare secure SQL query to update account info
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, phone_no = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $phone, $user_id);

    // Execute the query
    if ($stmt->execute()) {

        // Update session so changes reflect immediately
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['phone_no'] = $phone;

        // Redirect with success message
        header("Location: ../pages/customer/edit_user.php?success=account");
        exit;

    } else {

        // Redirect with error if update fails
        header("Location: ../pages/customer/edit_user.php?error=account");
        exit;
    }
}


// --------------------------------------------------
// HANDLE PASSWORD CHANGE
// --------------------------------------------------
// Runs when the user submits the "change password" form
if (isset($_POST['change_password'])) {

    // Get password inputs
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['user']['id'];

    // Get the current hashed password from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify if the entered current password is correct
    if (!password_verify($current_password, $user['password'])) {
        header("Location: ../pages/customer/edit_user.php?error=wrong_password");
        exit;
    }

    // Check if new password matches confirmation
    if ($new_password !== $confirm_password) {
        header("Location: ../pages/customer/edit_user.php?error=password_mismatch");
        exit;
    }

    // Ensure new password is at least 8 characters long
    if (strlen($new_password) < 8) {
        header("Location: ../pages/customer/edit_user.php?error=password_short");
        exit;
    }

    // Hash the new password before saving (for security)
    $hashed = password_hash($new_password, PASSWORD_ARGON2I);

    // Update password in database
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed, $user_id);

    // Execute update
    if ($stmt->execute()) {

        // Redirect with success message
        header("Location: ../pages/customer/edit_user.php?success=password");
        exit;

    } else {

        // Redirect with error if update fails
        header("Location: ../pages/customer/edit_user.php?error=password");
        exit;
    }
}


// --------------------------------------------------
// HANDLE ADDRESS UPDATE
// --------------------------------------------------
// Runs when the user submits the "update address" form
if (isset($_POST['update_address'])) {

    // Get and format inputs
    // ucwords() makes first letter of each word uppercase
    $name = trim(ucwords($_POST['name']));
    $province = trim(ucwords($_POST['province']));
    $city = trim(ucwords($_POST['city']));
    $unit = trim(ucwords($_POST['unit']));
    $barangay = trim(ucwords($_POST['barangay']));
    $user_id = $_SESSION['user']['id'];

    // Prepare SQL query to update address fields
    $stmt = $conn->prepare("UPDATE users SET province = ?, name = ?, city = ?, unit = ?, barangay = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $province, $name, $city, $unit, $barangay, $user_id);

    // Execute the update
    if ($stmt->execute()) {

        // Update session values so UI reflects changes immediately
        $_SESSION['user']['province'] = $province;
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['city'] = $city;
        $_SESSION['user']['unit'] = $unit;
        $_SESSION['user']['barangay'] = $barangay;

        // Redirect with success message
        header("Location: ../pages/customer/edit_user.php?success=address");
        exit;

    } else {

        // Redirect with error if update fails
        header("Location: ../pages/customer/edit_user.php?error=invalid_address");
        exit;
    }
}
?>