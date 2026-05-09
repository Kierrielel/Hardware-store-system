<?php
// ================= SESSION + SETUP =================
// Start the session so we can track user data (like login info)
session_start();

// Connect to the database so we can fetch products and categories
include 'backend/db_connect.php';

// Include the website header (navigation bar, logo, etc.)
include 'includes/header.php';
?>

<main class="content">

        <!-- ================= BANNER SECTION ================= -->
        <!-- This section shows a slider (images) and a Google Map -->
        <section class="container">
            <div class="banner-container">

                <!-- Left side: Image slider -->
                <div class="banner-left">
                    <div class="slider-wrapper">
                        <div class="slider">    

                            <!-- These are the images in the slider -->
                            <!-- Each image has an ID so navigation can jump to it -->
                            <img id="slide-1" src="resources/images/1banner.jpg" alt="Construction tools including hammer, wrench, and pliers arranged on a surface">
                            <img id="slide-2" src="resources/images/2banner.jpg" alt="Plumbing pipes, fittings, and fixtures for construction">
                        </div>

                        <!-- Navigation dots for switching slides -->
                        <div class="slider-nav">
                            <a href="#slide-1"></a>
                            <a href="#slide-2"></a>
                        </div>
                    </div>
                </div>

                <!-- Right side: Embedded Google Map -->
                <div class="banner-right">
                    <!-- This iframe displays the store location -->
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=..."
                        width="100%"
                        height="300"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe> 
                </div>

            </div>
        </section>

        <!-- ================= FEATURED PRODUCTS TITLE ================= -->
        <div class="separator">
            <h3>FEATURED PRODUCTS</h3>
        </div>

        <!-- ================= FEATURED PRODUCTS SECTION ================= -->
        <!-- Displays a limited number of products from the database -->
        <section class="featured">   
            <div class="product-grid">

                <?php 
                // Get up to 8 products from the database
                $sql = "SELECT * FROM products LiMIT 8";
                $result = mysqli_query($conn, $sql);

                // Check if there are products
                if(mysqli_num_rows($result) > 0){

                    // Loop through each product
                    while($row = mysqli_fetch_assoc($result)){
                ?>

                    <!-- Each product is clickable and leads to its own page -->
                    <a href="/Hardware_Store_System/pages/customer/product_page.php?prod_id=<?= $row['id']?>" class="prod-link">

                        <div class="product-card-featured">

                            <!-- Product image -->
                            <div class="img-con">
                                <img src="/Hardware_Store_System/<?php echo $row['image_path']; ?>" alt="<?php echo $row['name']; ?>" height="80" width="80">
                            </div>

                            <!-- Product name and price -->
                            <div class="prod-text-con">
                                <div class="text-con">
                                    <h4><?php echo $row["name"]; ?></h4>
                                </div>

                                <!-- number_format formats the price to 2 decimal places -->
                                <p>₱<?php echo number_format($row["price"], 2); ?></p>
                            </div>

                        </div>
                    </a>

                <?php 
                    }
                } else {
                ?>

                    <!-- If no products exist -->
                    <p>No products available yet.</p>

                <?php
                }
                ?>

            </div>
        </section>

        <!-- ================= CATEGORY TITLE ================= -->
        <div class="separator">
            <h3>SHOP BY CATEGORY</h3>
        </div>

        <!-- ================= CATEGORY SECTION ================= -->
        <!-- Displays all product categories -->
        <section class="cat-container">
            <div class="cat-grid">

                <?php 
                    // Get all categories from the database
                    $sql = "SELECT * FROM categories";
                    $result = mysqli_query($conn, $sql);

                    // If categories exist, loop through them
                    if(mysqli_num_rows($result) > 0):
                        while($row = mysqli_fetch_assoc($result)):
                ?>

                    <!-- Each category links to a filtered products page -->
                    <a href="/Hardware_Store_System/pages/customer/products.php?category_id=<?= $row['id']?>" class="cat-link">

                        <div class="cat-circle">
                            <!-- Display category name -->
                            <h3><?php echo $row["name"]?></h3>
                        </div>

                    </a>

                <?php 
                        endwhile;
                    endif;
                ?>

            </div>
        </section>

    </main>
</body>
</html>

<?php
// ================= FOOTER =================
// Include the footer (bottom part of the website)
include 'includes/footer.php';
?>