<?php
// index.php (root) - Home page ya public
session_start(); // kwa ku-check kama user ame-login (ili kuonyesha Ingia au Toka)
require_once 'config/database.php'; // au config yako
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KOBIBIE - TONICS</title>
    <style>
        body { font-family: Arial, sans-serif; margin:0; background:#f4f6f9; }
        .header {
            background:#2c3e50;
            color:white;
            padding:15px 30px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }
        .header h1 { margin:0; }
        .header nav a {
            color:white;
            margin-left:25px;
            text-decoration:none;
            font-weight:bold;
        }
        .header nav a:hover { color:#27ae60; }
        .container { max-width:1200px; margin:30px auto; padding:0 20px; }
        .products-grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:25px; }
        .product-card {
            background:white;
            border-radius:12px;
            overflow:hidden;
            box-shadow:0 4px 12px rgba(0,0,0,0.08);
            text-align:center;
            padding:15px;
        }
        .product-card img { max-width:100%; height:180px; object-fit:contain; }
        .btn-add {
            background:#e67e22;
            color:white;
            border:none;
            padding:10px 20px;
            border-radius:6px;
            cursor:pointer;
            font-weight:bold;
            margin-top:10px;
            width:80%;
        }
    </style>
</head>
<body>

<header class="header">
    <h1>KOBBIE - TONICS</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="frontend/products.php">Our Products</a>
        <a href="frontend/about.php">About Us</a>
        <a href="frontend/contact.php">Contact / Location</a>
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <a href="frontend/cart.php">Cart</a>
            <a href="frontend/checkout.php">Checkout</a>
            <a href="frontend/orders.php">Orders</a>
            <a href="frontend/logout.php">Logout (<?= htmlspecialchars($_SESSION['full_name']) ?>)</a>
        <?php else: ?>
            <a href="frontend/login.php">Login</a>
            <a href="frontend/register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>

<div class="container">
    <h1 style="text-align:center;">Karibu Kobbie Tonics</h1>
    <p style="text-align:center; color:#555; margin-bottom:40px;">Duka la kielektroniki la bei nafuu na ubora wa hali ya juu</p>

    <div class="products-grid">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM products LIMIT 12");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='product-card'>";
            if ($row['image']) {
                echo "<img src='uploads/products/" . basename($row['image']) . "' alt='{$row['name']}'>";
            } else {
                echo "<p>Hakuna picha</p>";
            }
            echo "<h3>{$row['name']}</h3>";
            echo "<p>TZS " . number_format($row['price']) . "</p>";
            echo "<p>Stock: {$row['stock']}</p>";
            echo "<button class='btn-add' onclick='alert(\"Ongeza kwenye cart - login ili kuendelea\")'>Ongeza kwenye Cart</button>";
            echo "</div>";
        }
        mysqli_close($conn);
        ?>
    </div>
</div>

</body>
</html>