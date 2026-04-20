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
        <section class="slider-section">
            <div class="slider">
                
            </div>
        </section>

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