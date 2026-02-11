<?php
header('Content-Type: application/json');
require_once '../database.php';
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['success' => false, 'error' => 'Ingia kwanza']);
    exit;
}

$user_id = (int)$_SESSION['user_id'];

$cart_result = mysqli_query($conn, "SELECT id FROM carts WHERE user_id = $user_id");
$cart = mysqli_fetch_assoc($cart_result);

if ($cart) {
    mysqli_query($conn, "DELETE FROM cart_items WHERE cart_id = " . (int)$cart['id']);
}

echo json_encode(['success' => true]);

mysqli_close($conn);
?>