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
    <title>Sign-up</title>
</head>
<body>
    <div class="signup_container">
        <div id="logo">
            <img src="resources/images/logo.png" alt="logo" height="50px" width="50px">
        </div>
        <h1>Create an Account</h1>
        <form action="backend/process_login.php" method="post">
            <input type="hidden" name="action" value="register">

            <div class="input-container">
                <input type="email" name="email" id="email" placeholder=" " required>
                <label for="email">Email</label>
            </div>
            
            <div class="input-container">
                <input type="text" name="phone_no" id="phone_no" placeholder=" " required>
                <label for="phone_no">Phone no.</label>
            </div>
        
            <div class="input-container">
                <input type="password" name="password" id="password" placeholder=" " required>
                <label for="password">Password</label>
            </div>

            <button type="submit" class="btn-signup">Sign up</button>
    </form>
    <a href="login.php" class="btn-create">Already have an Account</a>
    </div>
</body>
</html>