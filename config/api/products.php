<?php
header('Content-Type: application/json');
require_once '../database.php';

// Get search parameters (optional)
$search_name     = isset($_GET['search_name'])     ? trim($_GET['search_name'])     : '';
$search_category = isset($_GET['search_category']) ? trim($_GET['search_category']) : '';

// Base query
$query = "SELECT p.id, p.name, p.description, p.price, p.stock, p.image, 
                 COALESCE(c.name, 'Hakuna Category') AS category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE 1=1";

$params = [];
$types  = "";

// Add search conditions
if ($search_name !== '') {
    $query .= " AND p.name LIKE ?";
    $params[] = "%$search_name%";
    $types   .= "s";
}

if ($search_category !== '') {
    $query .= " AND COALESCE(c.name, '') LIKE ?";
    $params[] = "%$search_category%";
    $types   .= "s";
}

// Order by name
$query .= " ORDER BY p.name ASC";

// Prepare and execute
$stmt = mysqli_prepare($conn, $query);

if ($params) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

if (!mysqli_stmt_execute($stmt)) {
    echo json_encode(['error' => 'Tatizo la query: ' . mysqli_error($conn)]);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit;
}

$result = mysqli_stmt_get_result($stmt);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// Return clean JSON
echo json_encode($products);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>