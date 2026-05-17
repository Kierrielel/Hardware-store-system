<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS files for styling customer pages -->
    <link rel="stylesheet" href="/Hardware_Store_System/resources/css/header.css">
    <link rel="stylesheet" href="/Hardware_Store_System/resources/css/index.css">
    <link rel="stylesheet" href="/Hardware_Store_System/resources/css/products.css">
    <link rel="stylesheet" href="/Hardware_Store_System/resources/css/product_page.css">
    <link rel="stylesheet" href="/Hardware_Store_System/resources/css/cart.css">
    <link rel="stylesheet" href="/Hardware_Store_System/resources/css/account.css">
    <link rel="stylesheet" href="/Hardware_Store_System/resources/css/edit_user.css">
    <link rel="stylesheet" href="/Hardware_Store_System/resources/css/alert.css">

    <!-- Google icons (used for search icon) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search" />

    <!-- Title shown in browser tab -->
    <title>RM LAZARO ENTERPRISES HARDWARE</title>
</head>

<body>
    <!-- Main header -->
    <header>

        <!-- Top banner (logo, name, search) -->
        <div class="banner">

            <!-- Company logo -->
            <div class="logo">
                <img src="/Hardware_Store_System/resources/images/logo.png" alt="logo" height="50px" width="50px">
            </div>

            <!-- Business name -->
            <div class="banner-text">

                <!-- First line of name -->
                <div class="text-1">
                    <h2>RM LAZARO ENTERPRISES</h2>
                </div>

                <!-- Second line of name -->
                <div class="text-2">
                    <h2>HARDWARE</h2>
                </div>

            </div>

            <!-- Search container -->
            <div class="search-con">

                <!-- Sends search input using GET -->
                <form action="/Hardware_Store_System/pages/customer/products.php" method="get">

                    <div class="search-bar">

                        <!-- Search icon -->
                        <span class="search-icon material-symbols-outlined">search</span>

                        <!-- Search input -->
                        <!-- Keeps previous search value and prevents XSS -->
                        <input class="search-input" type="search" name="search" id="search" placeholder="Search"  
                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">    

                    </div>
                </form>
            </div>
        </div>

        <!-- Navigation bar -->
        <div class="banner-2">
            <nav>

                <!-- Navigation links container -->
                <div class="links-container">

                    <!-- Home page link -->
                    <a href="/Hardware_Store_System/index.php" class="home-link">Home</a>

                    <!-- Products page link -->
                    <a href="/Hardware_Store_System/pages/customer/products.php" class="shop-link">Products</a>

                    <!-- Cart page link with icon -->
                    <a href="/Hardware_Store_System/pages/customer/cart.php" class="cart-link">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                            <path d="M223.5-103.5Q200-127 200-160t23.5-56.5Q247-240 280-240t56.5 23.5Q360-193 360-160t-23.5 56.5Q313-80 280-80t-56.5-23.5Zm400 0Q600-127 600-160t23.5-56.5Q647-240 680-240t56.5 23.5Q760-193 760-160t-23.5 56.5Q713-80 680-80t-56.5-23.5ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z"/>
                        </svg>
                    </a>

                    <!-- PHP checks if user is logged in -->
                    <?php if (isset($_SESSION['user'])): ?>   

                        <!-- Shows username if logged in -->
                        <a href="/Hardware_Store_System/pages/customer/account.php" class="user-login">

                            <!-- User icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                            <path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm146.5-204.5Q340-521 340-580t40.5-99.5Q421-720 480-720t99.5 40.5Q620-639 620-580t-40.5 99.5Q539-440 480-440t-99.5-40.5ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm100-95.5q47-15.5 86-44.5-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160q53 0 100-15.5ZM523-537q17-17 17-43t-17-43q-17-17-43-17t-43 17q-17 17-17 43t17 43q17 17 43 17t43-17Zm-43-43Zm0 360Z"/>
                            </svg>

                            <!-- Displays username -->
                            <p><?= $_SESSION['user']['username'] ?></p>
                        </a>

                    <?php else: ?>  

                        <!-- Shows login link if not logged in -->
                        <a href="/Hardware_Store_System/login.php" class="user-login">

                            <!-- User icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                            <path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm146.5-204.5Q340-521 340-580t40.5-99.5Q421-720 480-720t99.5 40.5Q620-639 620-580t-40.5 99.5Q539-440 480-440t-99.5-40.5ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm100-95.5q47-15.5 86-44.5-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160q53 0 100-15.5ZM523-537q17-17 17-43t-17-43q-17-17-43-17t-43 17q-17 17-17 43t17 43q17 17 43 17t43-17Zm-43-43Zm0 360Z"/>
                            </svg>

                            <!-- Login text -->
                            <p>login</p>
                        </a>

                    <?php endif; ?>

                </div>
            </nav>
        </div>
    </header>