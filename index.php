<?php
session_start();
include 'includes/header.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/css/index.css">
    <title>RM LAZARO ENTERPRISES - Home</title>
</head>
<body>
    <main class="content">
        <section class="container">
            <div class="slider-wrapper">
                <div class="slider">    
                    <img id="slide-1" src="resources/images/1banner.jpg" alt="Construction tools including hammer, wrench, and pliers arranged on a surface">
                    <img id="slide-2" src="resources/images/2banner.jpg" alt="Plumbing pipes, fittings, and fixtures for construction">
                </div>
                <div class="slider-nav">
                    <a href="#slide-1"></a>
                    <a href="#slide-2"></a>
                </div>
            </div>
        </section>
        <div class="separator">
            <hr>
                <div class="separator-text">
                    <h3>FEATURED PRODUCT</h3>
                </div>
            <hr>
        </div>
        <section class="featured">
            <h3>Featured Categories</h3>
            <div class="category-grid">
                <div class="category-card">
                    <h4>Plumbing</h4>
                    <p>Pipes and fixtures.</p>
                </div>
                <div class="category-card">
                    <h4>Electrical</h4>
                    <p>Wires and lighting.</p>
                </div>
                <div class="category-card">
                    <h4>Hand Tools</h4>
                    <p>Wrenches and hammers.</p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>

<?php
include 'includes/footer.php';
?>