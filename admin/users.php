<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ./index.php");
    exit();
}

include('../include/config.php');
include('../include/header.php');
include('./admin-nav.php');

// Fetch users and admins separately
$users = $conn->query("SELECT * FROM users WHERE role='user' ORDER BY id DESC");
$admins = $conn->query("SELECT * FROM users WHERE role IN ('admin','super_admin') ORDER BY id DESC");
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">User Management</h2>

    <!-- Nav Tabs -->
    <ul class="nav nav-tabs" id="userTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">Users</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="admins-tab" data-bs-toggle="tab" data-bs-target="#admins" type="button" role="tab">Admins</button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-4">
        <!-- Users Tab -->
        <div class="tab-pane fade show active" id="users" role="tabpanel">
            <?php if ($users && $users->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-white text-start">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <?php if ($_SESSION['admin_logged_in'] == true && $_SESSION['admin_role'] === 'super_admin' ): ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            while ($row = $users->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <?php if ($_SESSION['admin_logged_in'] == true && $_SESSION['admin_role'] === 'super_admin'): ?>
                                        <td><a href="delete-users.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">No users found.</p>
            <?php endif; ?>
        </div>

        <!-- Admins Tab -->
        <div class="tab-pane fade" id="admins" role="tabpanel">
            <?php if ($admins && $admins->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-white text-start">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Role</th>
                                <th>Email</th>
                                <?php if ($_SESSION['admin_logged_in'] == true && $_SESSION['admin_role'] === 'super_admin' ): ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            while ($row = $admins->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['role']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <?php if ($_SESSION['admin_logged_in'] == true && $_SESSION['admin_role'] === 'super_admin' ): ?>
                                        <td><a href="delete-users.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a></td>
                                 
                                        
                                    <?php endif; ?>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">No admins found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

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