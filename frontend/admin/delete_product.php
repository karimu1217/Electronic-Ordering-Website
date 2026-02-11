<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role_id'] != 1) {
    header("Location: ../../login.php");
    exit;
}
require_once '../../config/database.php';
include 'admin_header.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: products.php?error=ID batili");
    exit;
}

mysqli_query($conn, "DELETE FROM products WHERE id = $id");
header("Location: products.php?msg=Bidhaa imefutwa");
exit;
?>