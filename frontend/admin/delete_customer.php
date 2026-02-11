<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role_id'] != 1) {
    header("Location: ../../login.php");
    exit;
}
require_once '../../config/database.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: customers.php?error=ID batili");
    exit;
}

mysqli_query($conn, "DELETE FROM users WHERE id = $id AND role_id = 2");
header("Location: customers.php?msg=Customer amefutwa vizuri");
exit;
?>