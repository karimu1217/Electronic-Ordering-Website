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
    header("Location: categories.php?error=ID batili");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM categories WHERE id = $id");
$category = mysqli_fetch_assoc($result);

if (!$category) {
    header("Location: categories.php?error=Category haipatikani");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($name)) {
        $error = "Jina la category ni lazima";
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE categories SET name = ?, description = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssi", $name, $description, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: categories.php?msg=Category imehaririwa vizuri");
            exit;
        } else {
            $error = "Tatizo: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<div class="container">
    <h1>Hariri Category: <?= htmlspecialchars($category['name']) ?></h1>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Jina la Category *</label>
            <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Maelezo</label>
            <textarea name="description" rows="5"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
        </div>
        <button type="submit" style="background:#f39c12; color:white; padding:12px 25px; border:none; border-radius:6px;">Hifadhi Mabadiliko</button>
        <a href="categories.php" style="margin-left:15px; color:#555;">Rudi nyuma</a>
    </form>
</div>