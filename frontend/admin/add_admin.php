<?php
session_start();
if ($_SESSION['is_super_admin'] != 1) {
    header("Location: ../../login.php");
    exit;
}
if (!isset($_SESSION['logged_in']) || $_SESSION['role_id'] != 1 || ($_SESSION['is_super_admin'] ?? 0) != 1) {
    header("Location: ../../login.php");
    exit;
}
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = password_hash(trim($_POST['password'] ?? ''), PASSWORD_DEFAULT);

    if (empty($full_name) || empty($email) || empty($_POST['password'])) {
        $error = "Jaza jina, email na password";
    } else {
        // Check kama email tayari ipo
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '" . mysqli_real_escape_string($conn, $email) . "'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Email hii tayari imetumika";
        } else {
            $stmt = mysqli_prepare($conn, "INSERT INTO users (role_id, full_name, email, phone, password, is_super_admin) VALUES (1, ?, ?, ?, ?, 0)");
            mysqli_stmt_bind_param($stmt, "ssss", $full_name, $email, $phone, $password);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: customers.php?msg=Admin mpya ameongezwa");
                exit;
            } else {
                $error = "Tatizo: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<div class="container">
    <h1>Ongeza Admin Mpya</h1>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Jina Kamili *</label>
            <input type="text" name="full_name" required>
        </div>
        <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Simu</label>
            <input type="text" name="phone">
        </div>
        <div class="form-group">
            <label>Nenosiri * (kwa admin mpya)</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" style="background:#27ae60; color:white; padding:12px 25px; border:none; border-radius:6px;">
            Ongeza Admin
        </button>
        <a href="customers.php" style="margin-left:15px; color:#555;">Rudi nyuma</a>
    </form>
</div>