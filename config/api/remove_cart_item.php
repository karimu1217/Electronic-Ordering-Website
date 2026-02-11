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

if ($item_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Data batili']);
    exit;
}

$user_id = (int)$_SESSION['user_id'];

// Thibitisha item ni ya user huyu
$query = "DELETE ci FROM cart_items ci 
          JOIN carts c ON ci.cart_id = c.id 
          WHERE ci.id = $item_id AND c.user_id = $user_id";

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}

mysqli_close($conn);
?>