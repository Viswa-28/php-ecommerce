<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ./index.php");
    exit();
}


include('../include/config.php');
include('../include/header.php');
include('./admin-nav.php');

$sql="SELECT * FROM contacts ORDER BY id DESC LIMIT 10";
$result=$conn->query($sql);

if($result && $result->num_rows > 0){
    echo '<h2 class="sub text-center mt-5 mb-4">Enquiries</h2>';
    echo '<div class="container">';
    echo '<div class="table-responsive">';
    echo '<table class="table table-striped table-bordered text-white">';
    echo '<thead class="table-dark">';
    echo '<tr>';
    echo '<th class="text-start">ID</th>';
    echo '<th class="text-start">Name</th>';
    echo '<th class="text-start">Email</th>';
    echo '<th class="text-start">Message</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    $i=1;
    while($row=$result->fetch_assoc()){
        echo '<tr>';
        echo '<td>' . $i++ . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td>' . $row['message'] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
}else{
    echo '<p class="text-center text-white mt-4">No enquiries found.</p>';
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