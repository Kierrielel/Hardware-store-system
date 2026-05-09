<?php
// ================= SESSION + DATABASE + HEADER =================
// Start session to track user data (like login info)
session_start();

// Connect to the database
include '../../backend/db_connect.php';

// Include reusable header (navigation bar, etc.)
include '../../includes/header.php';
?>

    <main class="product-container">

        <!-- ================= SIDEBAR (FILTERS) ================= -->
        <aside class="sort-sidebar">

            <!-- CATEGORY FILTER -->
            <h3>Categories</h3>
            <div class="prod-link-con">

                <!-- Link to show ALL products (no filter) -->
                <a href="/Hardware_Store_System/pages/customer/products.php">
                    <div class="sidebar-text-links">
                        <p>All</p>
                    </div>
                </a>

                <?php
                // Get all categories from the database
                $sql = "SELECT * FROM categories";
                $result = mysqli_query($conn, $sql);

                // Check if categories exist
                if(mysqli_num_rows($result) > 0):
                    // Loop through each category
                    while($row = mysqli_fetch_assoc($result)):
                ?>
                    <!-- Each category becomes a clickable link -->
                    <a href="/Hardware_Store_System/pages/customer/products.php?category_id=<?= $row['id']?>">
                        <div class="sidebar-text-links">
                            <p><?php echo $row["name"]?></p>
                        </div>
                    </a>
                <?php
                    endwhile;
                endif;
                ?>    
            </div>

            <!-- BRAND FILTER -->
            <h3>Brands</h3>
            <div class="brand-link-con">
                <?php
                // Get unique (distinct) brands from products
                $sql = "SELECT DISTINCT brand FROM products WHERE brand IS NOT NULL AND brand != '' ORDER BY brand ASC";  
                $result = mysqli_query($conn, $sql);

                // Check if brands exist
                if(mysqli_num_rows($result) > 0):
                    // Loop through each brand
                    while($row = mysqli_fetch_assoc($result)):
                ?>
                    <!-- Each brand becomes a clickable link -->
                    <a href="/Hardware_Store_System/pages/customer/products.php?brand=<?= $row['brand']?>">
                        <div class="sidebar-text-links">
                            <p><?php echo $row["brand"]?></p>
                        </div>
                    </a>
                <?php
                    endwhile;
                endif;
                ?>    
            </div>
        </aside>

        <!-- ================= PRODUCT DISPLAY SECTION ================= -->
        <section class="product-section">
            <div class="product-grid-main">

                <?php 
                // ================= SEARCH FUNCTION =================
                // If user searched something (e.g. ?search=hammer)
                if (isset($_GET['search']) && !empty($_GET['search'])) {

                    // Add % for partial matching (LIKE query)
                    $search = '%' . $_GET['search'] . '%'; 

                    // SQL query to search in multiple fields
                    $sql = "SELECT products.*, categories.name as category_name 
                            FROM products 
                            JOIN categories ON products.category_id = categories.id 
                            WHERE products.name LIKE ? 
                            OR products.description LIKE ? 
                            OR products.brand LIKE ?
                            OR categories.name LIKE ?";

                    // Prepare statement (prevents SQL injection)
                    $stmt = $conn->prepare($sql);

                    // Bind search values (4 strings)
                    $stmt->bind_param("ssss", $search, $search, $search, $search);

                    // Execute query
                    $stmt->execute();

                    // Get results
                    $result = $stmt->get_result();                
                }

                // ================= CATEGORY FILTER =================
                // If user selected a category
                elseif (isset($_GET['category_id']) && !empty($_GET['category_id'])) {

                    $cat_id = $_GET['category_id'];

                    $sql = "SELECT products.*, categories.name as category_name 
                            FROM products 
                            JOIN categories ON products.category_id = categories.id 
                            WHERE products.category_id = ?";

                    $stmt = $conn->prepare($sql);

                    // "i" means integer
                    $stmt->bind_param("i", $cat_id);

                    $stmt->execute();
                    $result = $stmt->get_result();
                }

                // ================= BRAND FILTER =================
                // If user selected a brand
                elseif (isset($_GET['brand']) && !empty($_GET['brand'])) {

                    $brand = $_GET['brand'];

                    $sql = "SELECT * FROM products WHERE brand = ?";  
                    
                    $stmt = $conn->prepare($sql);

                    // "s" means string
                    $stmt->bind_param("s", $brand);

                    $stmt->execute();
                    $result = $stmt->get_result();
                }  

                // ================= DEFAULT (NO FILTER) =================
                // If no search or filters are applied, show all products
                else {
                    $result = $conn->query("SELECT products.*, categories.name as category_name 
                                            FROM products 
                                            JOIN categories ON products.category_id = categories.id");
                }
            
                // ================= DISPLAY PRODUCTS =================
                // Check if there are products to show
                if ($result->num_rows > 0):
                    
                    // Loop through each product
                    while ($row = $result->fetch_assoc()):
                ?>

                    <!-- Each product is clickable -->
                    <a href="/Hardware_Store_System/pages/customer/product_page.php?prod_id=<?= $row['id'] ?>" class="prod-link">
                        <div class="product-card-main">

                            <!-- Product Image -->
                            <div class="img-con-main">
                                <img src="/Hardware_Store_System/<?php echo $row['image_path']; ?>" 
                                     alt="<?php echo $row['name']; ?>" height="120" width="120">
                            </div>

                            <!-- Product Details -->
                            <div class="prod-text-main">
                                <div class="text-con-main">
                                    <h4><?php echo $row["name"]; ?></h4>
                                </div>

                                <!-- Format price to 2 decimal places -->
                                <p>₱<?php echo number_format($row["price"], 2); ?></p>

                                <!-- Show remaining stock -->
                                <p id="stock">Stock left: <?php echo $row["stock_quantity"]; ?></p>
                            </div>
                        </div>
                    </a>

                <?php 
                    endwhile;

                // ================= NO PRODUCTS FOUND =================
                else:
                ?>
                    <div class="empty-product">
                        <p>No products found.</p>
                    </div>
                <?php
                endif;
                ?>
            </div>
        </section>
    </main>
</body>
</html>

<?php
// ================= FOOTER =================
// Include reusable footer (closing layout, scripts, etc.)
include '../../includes/footer.php';
?>