<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit;
}
require_once '../../config/database.php';
include 'admin_header.php';

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $category_id = (int)($_POST['category_id'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $image_path = '';

    if (empty($name) || $price <= 0 || $category_id <= 0) {
        $error = "Jaza sehemu muhimu";
    } else {
        // Image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../../uploads/products/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = 'prod_' . time() . '.' . $ext;
            $target = $upload_dir . $filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $image_path = 'uploads/products/' . $filename;
            }
        }

        $stmt = mysqli_prepare($conn, "INSERT INTO products (category_id, name, description, price, stock, image) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "issdis", $category_id, $name, $description, $price, $stock, $image_path);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: products.php?msg=Bidhaa imeongezwa");
            exit;
        } else {
            $error = "Tatizo: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<div class="container">
    <h1>Ongeza Bidhaa Mpya</h1>
    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Jina la Bidhaa *</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Bei (TZS) *</label>
            <input type="number" name="price" step="0.01" min="0" required>
        </div>
        <div class="form-group">
            <label>Stock *</label>
            <input type="number" name="stock" min="0" required>
        </div>
        <div class="form-group">
            <label>Category *</label>
            <select name="category_id" required>
                <option value="">Chagua...</option>
                <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Maelezo</label>
            <textarea name="description" rows="5"></textarea>
        </div>
        <div class="form-group">
            <label>Picha</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <button type="submit" style="background:#27ae60; color:white; padding:12px 25px; border:none; border-radius:6px;">Ongeza Bidhaa</button>
    </form>
</div>