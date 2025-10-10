<?php
session_start();



if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ./index.php");
    exit();
}

include('../include/config.php');
include('../include/header.php');
include('./admin-nav.php');

// Total Sales
$totalSalesQuery = "SELECT SUM(price) AS total_sales FROM checkout";
$totalSalesResult = $conn->query($totalSalesQuery);
$totalSales = $totalSalesResult->fetch_assoc()['total_sales'] ?? 0;

// Today's Sales
$today = date("Y-m-d");
$todaySalesQuery = "SELECT SUM(price) AS today_sales FROM checkout WHERE DATE(created_at) = '$today'";
$todaySalesResult = $conn->query($todaySalesQuery);
$todaySales = $todaySalesResult->fetch_assoc()['today_sales'] ?? 0;

// Total Orders
$orderCountQuery = "SELECT COUNT(*) AS total_orders FROM checkout";
$orderCountResult = $conn->query($orderCountQuery);
$orderCount = $orderCountResult->fetch_assoc()['total_orders'] ?? 0;

// Fetch Orders
$sql = "SELECT * FROM checkout ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div class="container mt-5">

    <!-- Dashboard Cards -->
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card shadow-lg bg-primary text-white p-3 rounded">
                <h4>Total Sales</h4>
                <h2>₹<?= number_format($totalSales, 2); ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg bg-info text-white p-3 rounded">
                <h4>Today's Sales</h4>
                <h2>₹<?= number_format($todaySales, 2); ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg bg-warning text-white p-3 rounded">
                <h4>Orders Placed</h4>
                <h2><?= $orderCount; ?></h2>
            </div>
        </div>
    </div>

    <?php if ($_SESSION['admin_role'] === 'super_admin'): ?>
        <div class="text-end mb-3">
            <a href="create-admin.php" class="btn btn-success">
                + Create Admin
            </a>
        </div>
    <?php endif; ?>

    <div class="admin-page container py-4">
        <h1 class="text-center mb-4 text-white">Checkout Orders</h1>

        <div class="table-container table-responsive">
            <table class="table table-striped table-bordered text-white">
                <thead class="table-dark text-start">
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Productname</th>
                        <th>Product Image</th>
                        <th>Price (₹)</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Size</th>
                        <th>Ordered At</th>
                    </tr>
                </thead>
                <tbody class="text-start">
                    <?php $i=1; ?>
                    <?php if($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= htmlspecialchars($row['user']); ?></td>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                                <td>
                                    <img src="../uploads/<?= htmlspecialchars($row['image']); ?>" 
                                         alt="<?= htmlspecialchars($row['name']); ?>" 
                                         style="width:80px; height:80px; object-fit:cover; border-radius:5px;">
                                </td>
                                <td><?= number_format($row['price'], 2); ?></td>
                                <td><?= htmlspecialchars($row['description']); ?></td>
                                <td><?= htmlspecialchars($row['category']); ?></td>
                                <td><?= htmlspecialchars($row['size']); ?></td>
                                <td><?= htmlspecialchars($row['created_at']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .card {
        transition: 0.3s ease-in-out;
    }
    .card:hover {
        transform: scale(1.05);
    }
</style>
<!-- Footer -->
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

