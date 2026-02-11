<?php
header('Content-Type: application/json');
require_once '../database.php';
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['count' => 0]);
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_result = mysqli_query($conn, "SELECT id FROM carts WHERE user_id = $user_id");
$cart = mysqli_fetch_assoc($cart_result);

if (!$cart) {
    echo json_encode(['count' => 0]);
    exit;
}

$cart_id = $cart['id'];
$count_result = mysqli_query($conn, "SELECT SUM(quantity) AS total FROM cart_items WHERE cart_id = $cart_id");
$count = mysqli_fetch_assoc($count_result)['total'] ?? 0;

echo json_encode(['count' => (int)$count]);

mysqli_close($conn);
?>