<?php
session_start();
include("header.php");

// Thibitisha user ameingia
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
    include("header.php");
}

require_once '../config/database.php';

// Chukua jina la user
$full_name = $_SESSION['full_name'] ?? 'Mgeni';
$role_id   = $_SESSION['role_id'] ?? 2;
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kobbie Tonics</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .header {
            background: #2c3e50;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .logout {
            color: white;
            text-decoration: none;
            background: #e74c3c;
            padding: 8px 16px;
            border-radius: 6px;
        }
        .logout:hover {
            background: #c0392b;
        }
        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .welcome {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            text-align: center;
        }
        .welcome h2 {
            color: #27ae60;
            margin-bottom: 20px;
        }
        .actions {
            margin-top: 30px;
            text-align: center;
        }
        .btn {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 14px 30px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 17px;
            margin: 10px;
        }
        .btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="welcome">
        <h2>Karibu <?= htmlspecialchars($full_name) ?>!</h2>
        <p>Umekuja kwenye akaunti yako ya Kobbie Tonics.</p>

        <?php if ($role_id == 1): ?>
            <p><strong>Wewe ni Admin</strong> – Unaweza kusimamia bidhaa na maagizo.</p>
        <?php else: ?>
            <p><strong>Wewe ni Mteja</strong> – Unaweza kuangalia bidhaa na ku-agiza.</p>
        <?php endif; ?>
    </div>

    <div class="actions">
        <a href="products.php" class="btn">Angalia Bidhaa</a>
        <a href="cart.php" class="btn">Cart Yangu</a>
        <?php if ($role_id == 1): ?>
            <a href="admin/products.php" class="btn">Simamia Bidhaa (Admin)</a>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
<?php include("footer.php"); ?>