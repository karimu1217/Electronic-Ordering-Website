<?php

if (!isset($_SESSION['logged_in']) || $_SESSION['role_id'] != 1) {
    header("Location: ../../login.php");
    exit;
}

$full_name = $_SESSION['full_name'] ?? 'Admin';
?>

<header class="admin-header">
    <h1>Admin Panel - Kobbie Tonics</h1>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="products.php">Products</a>
        <a href="categories.php">Categories</a>
        <a href="customers.php">Customers</a>
        <a href="orders.php">Orders</a>
        <a href="../logout.php" style="background:#e74c3c; color:white; padding:8px 16px; border-radius:6px; text-decoration:none; margin-left:20px;">
            Toka (<?= htmlspecialchars($full_name) ?>)
        </a>
    </nav>
</header>

<style>
    .admin-header {
        background: #1a252f; /* Dark theme kwa admin */
        color: white;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }
    .admin-header h1 {
        margin: 0;
        font-size: 24px;
    }
    .admin-header nav a {
        color: white;
        margin-left: 25px;
        text-decoration: none;
        font-weight: bold;
        font-size: 16px;
    }
    .admin-header nav a:hover {
        color: #27ae60;
    }
</style>