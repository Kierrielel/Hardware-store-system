<?php
session_start();
include '../../backend/db_connect.php';
include '../../includes/header.php';
?>

    <main class="product-container">
        <aside class="sort-sidebar">
            <h3>Categories</h3>
            <div class="prod-link-con">
                <a href="/Hardware_Store_System/pages/customer/products.php">
                    <div class="sidebar-text-links">
                        <p>All</p>
                    </div>
                </a>
                <?php
                $sql = "SELECT * FROM categories";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0):
                    while($row = mysqli_fetch_assoc($result)):
                ?>
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
            <h3>Brands</h3>
            <div class="brand-link-con">
                <?php
                $sql = "SELECT DISTINCT brand FROM products WHERE brand IS NOT NULL AND brand != '' ORDER BY brand ASC";  
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0):
                    while($row = mysqli_fetch_assoc($result)):
                ?>
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
        <section class="product-section">
            <div class="product-grid-main">

                <?php 
                if (isset($_GET['search']) && !empty($_GET['search'])) {

                    $search = '%' . $_GET['search'] . '%'; 

                    $sql = "SELECT products.*, categories.name as category_name 
                            FROM products 
                            JOIN categories ON products.category_id = categories.id 
                            WHERE products.name LIKE ? 
                            OR products.description LIKE ? 
                            OR products.brand LIKE ?
                            OR categories.name LIKE ?";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssss", $search, $search, $search, $search);
                    $stmt->execute();
                    $result = $stmt->get_result();                
                }
                elseif (isset($_GET['category_id']) && !empty($_GET['category_id'])) {

                    $cat_id = $_GET['category_id'];

                    $sql = "SELECT products.*, categories.name as category_name 
                            FROM products 
                            JOIN categories ON products.category_id = categories.id 
                            WHERE products.category_id = ?";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $cat_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                }

                elseif (isset($_GET['brand']) && !empty($_GET['brand'])) {

                    $brand = $_GET['brand'];
                    $sql = "SELECT * FROM products WHERE brand = ?";  
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $brand);
                    $stmt->execute();
                    $result = $stmt->get_result();
                }  

                else {
                    $result = $conn->query("SELECT products.*, categories.name as category_name 
                                            FROM products 
                                            JOIN categories ON products.category_id = categories.id");
                }
            
                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                    <a href="/Hardware_Store_System/pages/customer/product_page.php?prod_id=<?= $row['id'] ?>" class="prod-link">
                        <div class="product-card-main">
                            <div class="img-con-main">
                                <img src="/Hardware_Store_System/<?php echo $row['image_path']; ?>" 
                                     alt="<?php echo $row['name']; ?>" height="120" width="120">
                            </div>
                            <div class="prod-text-main">
                                <div class="text-con-main">
                                    <h4><?php echo $row["name"]; ?></h4>
                                </div>
                                <p>₱<?php echo number_format($row["price"], 2); ?></p>
                                <p id="stock">Stock left: <?php echo $row["stock_quantity"]; ?></p>
                            </div>
                        </div>
                    </a>

                <?php 
                    endwhile;
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
include '../../includes/footer.php';
?>