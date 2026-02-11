<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit;
}
include 'admin_header.php';
?>
<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Karibu Admin <?= htmlspecialchars($_SESSION['full_name']) ?></p>
   <div style="margin:30px 0;">
    <a href="products.php" class="btn" style="background:#3498db; color:white; padding:12px 25px; border-radius:6px; text-decoration:none; margin-right:15px;">Simamia Bidhaa</a>
    <a href="categories.php" class="btn" style="background:#27ae60; color:white; padding:12px 25px; border-radius:6px; text-decoration:none; margin-right:15px;">Simamia Categories</a>
    <a href="customers.php" class="btn" style="background:#9b59b6; color:white; padding:12px 25px; border-radius:6px; text-decoration:none; margin-right:15px;">Wateja Wangu</a>
    <a href="orders.php" class="btn" style="background:#e67e22; color:white; padding:12px 25px; border-radius:6px; text-decoration:none;">Maagizo Yote</a>
</div>
</div>
