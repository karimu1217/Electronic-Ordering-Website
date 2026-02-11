<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role_id'] != 1) {
    header("Location: ../../login.php");
    exit;
}
require_once '../../config/database.php';
include 'admin_header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($name)) {
        $error = "Jina la category ni lazima";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO categories (name, description) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $name, $description);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: categories.php?msg=Category imeongezwa vizuri");
            exit;
        } else {
            $error = "Tatizo: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<div class="container">
    <h1>Ongeza Category Mpya</h1>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Jina la Category *</label>
            <input type="text" name="name" required placeholder="Mfano: Simu Mahiri">
        </div>
        <div class="form-group">
            <label>Maelezo (optional)</label>
            <textarea name="description" rows="5" placeholder="Eleza category hii..."></textarea>
        </div>
        <button type="submit" style="background:#27ae60; color:white; padding:12px 25px; border:none; border-radius:6px;">Ongeza Category</button>
        <a href="categories.php" style="margin-left:15px; color:#555;">Rudi nyuma</a>
    </form>
</div>