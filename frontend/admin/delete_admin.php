<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['role_id'] != 1) {
    header("Location: ../../login.php");
    exit;
}

// Zuia isipokuwa super admin
if ($_SESSION['is_super_admin'] != 1) {
    header("Location: ../../dashboard.php?error=Huna ruhusa ya kufuta admin");
    exit;
}

require_once '../../config/database.php';

$admin_id = (int)($_GET['id'] ?? 0);
if ($admin_id <= 0) {
    header("Location: customers.php?error=ID batili");
    exit;
}

// Zuia kufuta super admin (wewe mwenyewe)
$check = mysqli_query($conn, "SELECT is_super_admin FROM users WHERE id = $admin_id");
$admin = mysqli_fetch_assoc($check);

if (!$admin) {
    header("Location: customers.php?error=Admin haipatikani");
    exit;
}

if ($admin['is_super_admin'] == 1) {
    header("Location: customers.php?error=Huwezi kufuta super admin");
    exit;
}

// Futa admin (role_id = 1)
mysqli_query($conn, "DELETE FROM users WHERE id = $admin_id AND role_id = 1");

header("Location: customers.php?msg=Admin amefutwa vizuri");
exit;
?>