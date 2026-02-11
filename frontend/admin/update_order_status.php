<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role_id'] != 1) {
    header("Location: ../../login.php");
    exit;
}
require_once '../../config/database.php';

$order_id = (int)($_GET['id'] ?? 0);
$status = $_GET['status'] ?? '';

$valid_statuses = ['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled'];

if ($order_id <= 0 || !in_array($status, $valid_statuses)) {
    header("Location: orders.php?error=Data batili");
    exit;
}

mysqli_query($conn, "UPDATE orders SET status = '$status' WHERE id = $order_id");

header("Location: orders.php?msg=Status ya agizo imebadilishwa kuwa " . ucfirst($status));
exit;
?>