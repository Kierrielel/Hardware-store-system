<?php
session_start();
include 'backend/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/css/login.css">
    <title>Log-in</title>
</head>
<body>
    <div class="login_container">
        <div id="logo">
            <img src="resources/images/logo.png" alt="logo" height="50px" width="50px">
        </div>
        <h1>RM LAZARO ENTERPRISES</h1>
        <form action="backend/process_login.php" method="post">
            <input type="hidden" name="action" value="login">

            <div class="input-container">
                <input type="text" name="login_id" id="login_id" placeholder=" " required>
                <label for="login_id">Email or Phone no.</label>
            </div>
            
            <div class="input-container">
                <input type="password" name="password" id="password" placeholder=" " required>
                <label for="password">Password</label>
            </div>

            <button type="submit" class="btn-login">Log In</button>
        </form>
        <a href="#" class="forgot-password">Forgot Password?</a>
        <a href="signup.php" class="btn-create">Create Account</a>
    </div>
</body>
</html>