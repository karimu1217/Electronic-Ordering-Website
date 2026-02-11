<?php
header('Content-Type: application/json');
require_once '../database.php';
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['success' => false, 'error' => 'Ingia kwanza']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$product_id = (int)($input['product_id'] ?? 0);
$quantity = (int)($input['quantity'] ?? 1);

if ($product_id <= 0 || $quantity <= 0) {
    echo json_encode(['success' => false, 'error' => 'Data batili']);
    exit;
}

// Thibitisha user ana cart
$user_id = $_SESSION['user_id'];
$cart_result = mysqli_query($conn, "SELECT id FROM carts WHERE user_id = $user_id");
$cart = mysqli_fetch_assoc($cart_result);

if (!$cart) {
    // Create cart kama haipo
    mysqli_query($conn, "INSERT INTO carts (user_id) VALUES ($user_id)");
    $cart_id = mysqli_insert_id($conn);
} else {
    $cart_id = $cart['id'];
}

// Thibitisha product ipo na stock inatosha
$product_result = mysqli_query($conn, "SELECT stock FROM products WHERE id = $product_id");
$product = mysqli_fetch_assoc($product_result);

if (!$product || $product['stock'] < $quantity) {
    echo json_encode(['success' => false, 'error' => 'Bidhaa haipatikani au stock haitoshi']);
    exit;
}

// Ongeza au update cart item
$stmt = mysqli_prepare($conn, "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?) 
                               ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
mysqli_stmt_bind_param($stmt, "iii", $cart_id, $product_id, $quantity);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true, 'message' => 'Imeongezwa kwenye cart']);
} else {
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>