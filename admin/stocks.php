<?php



session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ./index.php");
    exit();
}



include('../include/config.php');
include('../include/header.php');
include('./admin-nav.php');
?>

<h2 class="sub text-center mt-5 mb-4">Stocks</h2>

<?php
if($_SESSION['admin_logged_in'] == true && $_SESSION['admin_role'] === 'super_admin'){
   ?> <div class="stock-btn primary d-flex justify-content-center align-items-center mb-4">
    <a href="add-stocks.php" class="text-white fw-bold text-decoration-none text-center">Add Stocks</a>
</div>
<?php
}
?>

<?php
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) { ?>
    <div class="row g-4 px-3 w-100">
        <?php while ($row = mysqli_fetch_assoc($result)) {
            $product_id = $row['id'];
            $product_name = $row['name'];
            $product_price = $row['price'];
            $product_image = $row['image'];
            $product_category = $row['category'];
            $product_description = $row['description'];
            $product_stock = $row['stock'];
        ?>
            <div class="col-3">
                <div class="card h-100 stock-card">
                    <img src="../uploads/<?php echo $product_image; ?>" class="card-img-top" alt="Product Image">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($product_name); ?></h5>
                        <p class="card-text text-muted text-white">Category: <?php echo htmlspecialchars($product_category); ?></p>
                        <p class="card-text small"><?php echo htmlspecialchars($product_description); ?></p>
                        <p class="card-text fw-bold mt-auto">Price: ₹<?php echo number_format($product_price, 2); ?></p>
                        <p class="card-text">Stock: <?php echo intval($product_stock); ?></p>
                        <div class="mt-2 d-flex gap-2">
                            <a href="edit-stocks.php?product_id=<?php echo $product_id; ?>" class="btn btn-primary flex-fill">Edit</a>
                            <a href="delete-stocks.php?product_id=<?php echo $product_id; ?>" class="btn btn-danger flex-fill">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php
} else {
    echo '<p class="text-center text-white mt-4">No products found.</p>';
}
?>

<footer class="bg-dark text-white pt-4 pb-2 mt-5">
    <div class="container">
        <div class="row">

            <!-- About Section -->
            <div class="col-md-4 mb-3">
                <h5>Midnight Vogue</h5>
                <p class="small">
Midnight Vogue is your go-to destination for premium fashion. We deliver quality, style, and elegance right to your doorstep.
            </p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-4 mb-3">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="dashboard.php" class="text-white text-decoration-none">Dashboard</a></li>
                    <li><a href="stocks.php" class="text-white text-decoration-none">Stocks</a></li>
                    <li><a href="users.php" class="text-white text-decoration-none">Users</a></li>
                    <li><a href="enquiry.php" class="text-white text-decoration-none">Enquiry</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-md-4 mb-3">
                <h5>Contact Us</h5>
                <p class="small mb-1"><i class="bi bi-geo-alt-fill"></i> 123 Main Street, City, Country</p>
                <p class="small mb-1"><i class="bi bi-envelope-fill"></i> viswa@example.com</p>
                <p class="small"><i class="bi bi-telephone-fill"></i> +91 6382828282</p>
            </div>

        </div>

        <hr class="bg-secondary">

        <!-- Footer Bottom -->
        <div class="row">
            <div class="col text-center small">
                &copy; <?= date('Y'); ?> Midnight Vogue. All rights reserved.
            </div>
        </div>
    </div>
</footer>