<?php
header('Content-Type: application/json');
require_once '../database.php';
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['items' => []]);
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_result = mysqli_query($conn, "SELECT id FROM carts WHERE user_id = $user_id");
$cart = mysqli_fetch_assoc($cart_result);

if (!$cart) {
    echo json_encode(['items' => []]);
    exit;
}

$cart_id = $cart['id'];
$query = "SELECT ci.id AS cart_item_id, ci.quantity, p.id AS product_id, p.name, p.price, p.image 
          FROM cart_items ci 
          JOIN products p ON ci.product_id = p.id 
          WHERE ci.cart_id = $cart_id";

$result = mysqli_query($conn, $query);
$items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
}

echo json_encode(['items' => $items]);

mysqli_close($conn);
?>