<?php
// ================= SESSION + DATABASE =================
// Start session to access user data (like login status)
session_start();

// Connect to the database
include '../../backend/db_connect.php';


// ================= CHECK PRODUCT ID =================
// Make sure a product ID is provided in the URL (e.g. ?prod_id=1)
// If not, redirect user back to product list
if (!isset($_GET['prod_id'])) {
    header("Location: products.php");
    exit;
}


// ================= FETCH PRODUCT FROM DATABASE =================
// Get product ID from URL
$prod_id = $_GET['prod_id'];

// SQL query to get product details + category name
$stmt = $conn->prepare("SELECT products.*, categories.name AS category_name 
                         FROM products 
                         JOIN categories ON products.category_id = categories.id 
                         WHERE products.id = ?");

// Bind product ID safely (integer)
$stmt->bind_param("i", $prod_id);

// Execute query
$stmt->execute();

// Get result
$result = $stmt->get_result();

// Fetch product as an associative array
$product = $result->fetch_assoc();


// ================= CHECK IF PRODUCT EXISTS =================
// If no product is found, redirect back to product list
if (!$product) {
    header("Location: products.php");
    exit;
}


// ================= INCLUDE HEADER =================
// Load header (navigation, layout, etc.)
include '../../includes/header.php';
?>

<main class="prod-page-container">

    <!-- ================= ALERT MESSAGES ================= -->
    <!-- Show success message (e.g. after adding to cart) -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert-success">
            <?php 
            if($_GET['success'] === 'added') echo "Added to cart successfully!";
            ?>
        </div>
    <?php endif; ?>
        
    <!-- Show error message -->
    <?php if (isset($_GET['error'])): ?>
        <div class="alert-error">
            <?php 
            if($_GET['error'] === 'not_enough_stock') echo "Invalid product quantity.";
            ?>
        </div>
     <?php endif; ?>

    <!-- ================= PRODUCT DISPLAY ================= -->
    <div class="prod-card-align">
        <div class="prod-page-card">

            <!-- PRODUCT IMAGE -->
            <div class="prod-page-img">
                <img src="/Hardware_Store_System/<?php echo $product['image_path']; ?>" 
                     alt="<?php echo $product['name']; ?>">
            </div>

            <!-- PRODUCT DETAILS -->
            <div class="prod-page-details">

                <!-- Show category -->
                <span class="prod-page-category"><?php echo $product['category_name']; ?></span>

                <!-- Show brand only if it exists -->
                <?php if(!empty($product['brand'])): ?>
                    <span class="prod-page-brand"><?php echo $product['brand']; ?></span>
                <?php endif; ?>

                <!-- Product name -->
                <h1 class="prod-page-name"><?php echo $product['name']; ?></h1>

                <!-- Product price (formatted to 2 decimal places) -->
                <p class="prod-page-price">₱<?php echo number_format($product['price'], 2); ?></p>

                <!-- ================= STOCK DISPLAY ================= -->
                <!-- Adds 'low-stock' class if stock is 20 or below -->
                <p class="prod-page-stock <?= $product['stock_quantity'] <= 20 ? 'low-stock' : '' ?>">

                    <!-- If product is available -->
                    <?php if($product['stock_quantity'] > 0): ?>
                        <?php echo $product['stock_quantity']; ?> left in stock

                    <!-- If no stock -->
                    <?php else: ?>
                        Out of stock
                    <?php endif; ?>
                </p>

                <!-- ================= ADD TO CART SECTION ================= -->
                <!-- Only show form if product is in stock -->
                <?php if($product['stock_quantity'] > 0): ?>

                    <!-- Form sends data to add_to_cart.php -->
                    <form action="/Hardware_Store_System/backend/add_to_cart.php" method="POST">

                        <!-- Hidden field to send product ID -->
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                        <!-- Quantity input -->
                        <div class="qty-container">
                            <label>Quantity</label>
                            <div class="qty-input">

                                <!-- User selects quantity (cannot exceed stock) -->
                                <input type="number" name="quantity" value="1" min="1" 
                                       max="<?php echo $product['stock_quantity']; ?>">
                            </div>
                        </div>

                        <?php 
                        // ================= CHECK IF USER IS LOGGED IN =================
                        // If user is logged in, allow adding to cart
                        if(isset($_SESSION['user'])):
                        ?>

                        <!-- Submit button -->
                        <button type="submit" class="add-to-cart-btn">
                            Add to Cart
                        </button>

                        <?php
                        else:
                        ?>        

                        <!-- If not logged in, redirect to login page -->
                        <a href="../../login.php" onclick="add_to_cart_error()" class="add-to-cart-btn">
                            Add to Cart
                        </a>

                        <?php        
                        endif
                        ?>
                    </form>

                <?php else: ?>

                    <!-- If out of stock, disable button -->
                    <button class="add-to-cart-btn disabled" disabled>Out of Stock</button>

                <?php endif; ?>
            </div>
        </div>

        <!-- ================= PRODUCT DESCRIPTION ================= -->
        <div class="prod-page-card2">

            <!-- Show description only if it exists -->
            <?php if(!empty($product['description'])): ?>
                <div class="prod-page-desc">
                    <h4>Description</h4>

                    <!-- Convert special characters + preserve line breaks -->
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- ================= JAVASCRIPT FUNCTION ================= -->
<script>
// Shows alert if user clicks "Add to Cart" while not logged in
function add_to_cart_error() {
  alert("Please login first!");
}
</script>

</body>
</html>

<?php
// ================= FOOTER =================
// Include footer (closing layout, scripts, etc.)
include '../../includes/footer.php';
?>