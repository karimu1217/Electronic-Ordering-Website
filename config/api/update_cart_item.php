<?php
header('Content-Type: application/json');
require_once '../database.php';
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['success' => false, 'error' => 'Ingia kwanza']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$item_id = (int)($input['item_id'] ?? 0);
$change = (int)($input['change'] ?? 0);

if ($item_id <= 0 || $change === 0) {
    echo json_encode(['success' => false, 'error' => 'Data batili']);
    exit;
}

$user_id = (int)$_SESSION['user_id'];

// Thibitisha item ni ya user huyu
$check = mysqli_query($conn, "SELECT ci.id, ci.quantity FROM cart_items ci JOIN carts c ON ci.cart_id = c.id WHERE ci.id = $item_id AND c.user_id = $user_id");
$item = mysqli_fetch_assoc($check);

if (!$item) {
    echo json_encode(['success' => false, 'error' => 'Item haipo kwenye cart yako']);
    exit;
}

$new_quantity = $item['quantity'] + $change;

if ($new_quantity <= 0) {
    // Futa item kama quantity inakuwa 0 au chini
    mysqli_query($conn, "DELETE FROM cart_items WHERE id = $item_id");
} else {
    mysqli_query($conn, "UPDATE cart_items SET quantity = $new_quantity WHERE id = $item_id");
}

echo json_encode(['success' => true]);

mysqli_close($conn);
?>