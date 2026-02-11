<?php
// backend/api/create_order.php - HAKUNA space au echo kabla ya header
header('Content-Type: application/json');
require_once '../database.php';
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['success' => false, 'error' => 'Ingia kwanza']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$items = $input['items'] ?? [];
$total = (float)($input['total'] ?? 0);
$full_name = trim($input['full_name'] ?? '');
$address = trim($input['address'] ?? '');
$phone = trim($input['phone'] ?? '');
$payment_method = $input['payment_method'] ?? 'cash_on_delivery';

if (empty($items) || $total <= 0 || empty($full_name) || empty($address) || empty($phone)) {
    echo json_encode(['success' => false, 'error' => 'Data batili au cart tupu']);
    exit;
}

$user_id = (int)$_SESSION['user_id'];

// Save order
$stmt = mysqli_prepare($conn, "INSERT INTO orders (user_id, total_amount, address, phone, payment_method) VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "idsss", $user_id, $total, $address, $phone, $payment_method);
if (!mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => false, 'error' => 'Tatizo la kuhifadhi agizo: ' . mysqli_error($conn)]);
    exit;
}
$order_id = mysqli_insert_id($conn);
mysqli_stmt_close($stmt);

// Save order items
foreach ($items as $item) {
    $product_id = (int)($item['id'] ?? 0);
    $quantity = (int)($item['quantity'] ?? 1);
    $price = (float)($item['price'] ?? 0);

    if ($product_id <= 0) continue;

    $stmt = mysqli_prepare($conn, "INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iiid", $order_id, $product_id, $quantity, $price);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Clear cart_items
$cart_result = mysqli_query($conn, "SELECT id FROM carts WHERE user_id = $user_id");
$cart = mysqli_fetch_assoc($cart_result);
if ($cart) {
    mysqli_query($conn, "DELETE FROM cart_items WHERE cart_id = " . (int)$cart['id']);
}

echo json_encode(['success' => true, 'order_id' => $order_id]);

mysqli_close($conn);
?>