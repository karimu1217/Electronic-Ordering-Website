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

$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header("Location: products.php?error=Bidhaa haipatikani");
    exit;
}

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $category_id = (int)($_POST['category_id'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $image_path = $product['image'];

    if (empty($name) || $price <= 0 || $category_id <= 0) {
        $error = "Jaza sehemu muhimu";
    } else {
        // Image upload (kama mpya)
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

        $stmt = mysqli_prepare($conn, "UPDATE products SET category_id = ?, name = ?, description = ?, price = ?, stock = ?, image = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "issdisi", $category_id, $name, $description, $price, $stock, $image_path, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: products.php?msg=Bidhaa imehaririwa");
            exit;
        } else {
            $error = "Tatizo: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<div class="container">
    <h1>Hariri Bidhaa: <?= htmlspecialchars($product['name']) ?></h1>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Jina la Bidhaa *</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Bei (TZS) *</label>
            <input type="number" name="price" step="0.01" min="0" value="<?= $product['price'] ?>" required>
        </div>
        <div class="form-group">
            <label>Stock *</label>
            <input type="number" name="stock" min="0" value="<?= $product['stock'] ?>" required>
        </div>
        <div class="form-group">
            <label>Category *</label>
            <select name="category_id" required>
                <option value="">Chagua...</option>
                <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Maelezo</label>
            <textarea name="description" rows="5"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label>Picha (acha tupu kama hutaki kubadilisha)</label>
            <input type="file" name="image" accept="image/*">
            <?php if ($product['image']): ?>
                <p>Picha ya sasa: <img src="/kobbie-tonics/<?= htmlspecialchars($product['image']) ?>" width="100"></p>
            <?php endif; ?>
        </div>
        <button type="submit" style="background:#f39c12; color:white; padding:12px 25px; border:none; border-radius:6px;">Hifadhi Mabadiliko</button>
        <a href="products.php" style="margin-left:15px; color:#555;">Rudi nyuma</a>
    </form>
</div>