<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role_id'] != 1) {
    header("Location: ../../login.php");
    exit;
}
require_once '../../config/database.php';
include 'admin_header.php';
?>
<div class="container">
    <h1>Maagizo Yote</h1>

    <table style="width:100%; border-collapse:collapse; margin-top:20px;">
        <tr style="background:#34495e; color:white;">
            <th style="padding:12px;">Agizo #</th>
            <th style="padding:12px;">Customer</th>
            <th style="padding:12px;">Email</th>
            <th style="padding:12px;">Simu</th>
            <th style="padding:12px;">Anwani</th>
            <th style="padding:12px;">Jumla (TZS)</th>
            <th style="padding:12px;">Malipo</th>
            <th style="padding:12px;">Status</th>
            <th style="padding:12px;">Tarehe</th>
            <th style="padding:12px;">Bidhaa</th>
            <th style="padding:12px;">Chaguo</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT o.*, u.full_name, u.email, u.phone 
                                       FROM orders o 
                                       JOIN users u ON o.user_id = u.id 
                                       ORDER BY o.id DESC");
        while ($order = mysqli_fetch_assoc($result)) {
            echo "<tr style='border-bottom:1px solid #ddd;'>";
            echo "<td style='padding:12px;'>{$order['id']}</td>";
            echo "<td style='padding:12px;'>" . htmlspecialchars($order['full_name']) . "</td>";
            echo "<td style='padding:12px;'>" . htmlspecialchars($order['email']) . "</td>";
            echo "<td style='padding:12px;'>" . htmlspecialchars($order['phone']) . "</td>";
            echo "<td style='padding:12px;'>" . htmlspecialchars($order['address']) . "</td>";
            echo "<td style='padding:12px;'>" . number_format($order['total_amount']) . "</td>";
            echo "<td style='padding:12px;'>" . htmlspecialchars($order['payment_method']) . "</td>";
            echo "<td style='padding:12px;'>" . htmlspecialchars($order['status']) . "</td>";
            echo "<td style='padding:12px;'>" . $order['created_at'] . "</td>";

            // Bidhaa kwenye agizo
            $items_result = mysqli_query($conn, "SELECT p.name, oi.quantity, oi.price_at_purchase 
                                                 FROM order_items oi 
                                                 JOIN products p ON oi.product_id = p.id 
                                                 WHERE oi.order_id = {$order['id']}");
            $items_list = [];
            while ($item = mysqli_fetch_assoc($items_result)) {
                $items_list[] = htmlspecialchars($item['name']) . " x " . $item['quantity'] . " (TZS " . number_format($item['price_at_purchase']) . ")";
            }
            echo "<td style='padding:12px;'>" . implode('<br>', $items_list) . "</td>";

           echo "<td style='padding:12px;'>
    <a href='view_order.php?id={$order['id']}' style='background:#3498db; color:white; padding:8px 12px; border-radius:5px; text-decoration:none; margin-right:5px;'>Angalia</a>
    <a href='update_order_status.php?id={$order['id']}&status=shipped' onclick='return confirm(\"Badilisha status kuwa Shipped?\")' style='background:#f39c12; color:white; padding:8px 12px; border-radius:5px; text-decoration:none; margin-right:5px;'>Shipped</a>
    <a href='update_order_status.php?id={$order['id']}&status=delivered' onclick='return confirm(\"Badilisha status kuwa Delivered?\")' style='background:#27ae60; color:white; padding:8px 12px; border-radius:5px; text-decoration:none;'>Delivered</a>
</td>";
            echo "</tr>";
        }
        mysqli_close($conn);
        ?>
    </table>
</div>