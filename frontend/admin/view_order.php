<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role_id'] != 1) {
    header("Location: ../../login.php");
    exit;
}
require_once '../../config/database.php';
include 'admin_header.php';

$order_id = (int)($_GET['id'] ?? 0);
if ($order_id <= 0) {
    header("Location: orders.php?error=Agizo batili");
    exit;
}

$order_result = mysqli_query($conn, "SELECT o.*, u.full_name, u.email, u.phone 
                                     FROM orders o 
                                     JOIN users u ON o.user_id = u.id 
                                     WHERE o.id = $order_id");
$order = mysqli_fetch_assoc($order_result);

if (!$order) {
    header("Location: orders.php?error=Agizo halipatikani");
    exit;
}

$items_result = mysqli_query($conn, "SELECT p.name, oi.quantity, oi.price_at_purchase 
                                     FROM order_items oi 
                                     JOIN products p ON oi.product_id = p.id 
                                     WHERE oi.order_id = $order_id");
?>

<div class="container">
    <h1>Angalia Agizo #<?= $order['id'] ?></h1>

    <p><strong>Customer:</strong> <?= htmlspecialchars($order['full_name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
    <p><strong>Simu:</strong> <?= htmlspecialchars($order['phone']) ?></p>
    <p><strong>Anwani:</strong> <?= htmlspecialchars($order['address']) ?></p>
    <p><strong>Jumla:</strong> TZS <?= number_format($order['total_amount']) ?></p>
    <p><strong>Malipo:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
    <p><strong>Tarehe:</strong> <?= $order['created_at'] ?></p>

    <!--<h2>Bidhaa Zilizopo kwenye Agizo</h2>
    <table style="width:100%; border-collapse:collapse;">
        <tr style="background:#f1f1f1;">
            <th style="padding:10px;">Bidhaa</th>
            <th style="padding:10px;">Kiasi</th>
            <th style="padding:10px;">Bei</th>
            <th style="padding:10px;">Jumla</th>
        </tr>
      //  <?php while ($item = mysqli_fetch_assoc($items_result)): ?>
            <tr style="border-bottom:1px solid #eee;">
                <td style="padding:10px;"><?= htmlspecialchars($item['name']) ?></td>
                <td style="padding:10px;"><?= $item['quantity'] ?></td>
                <td style="padding:10px;">TZS <?= number_format($item['price_at_purchase']) ?></td>
                <td style="padding:10px;">TZS <?= number_format($item['price_at_purchase'] * $item['quantity']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>-->

    <a href="orders.php" style="display:inline-block; margin-top:20px; background:#3498db; color:white; padding:10px 20px; border-radius:6px; text-decoration:none;">Rudi kwenye Maagizo Yote</a>
</div>