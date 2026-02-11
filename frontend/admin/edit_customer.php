<?php
session_start();

// Thibitisha ni admin (role_id = 1)
if (!isset($_SESSION['logged_in']) || $_SESSION['role_id'] != 1) {
    header("Location: ../../login.php");
    exit;
}

require_once '../../config/database.php';

$customer_id = (int)($_GET['id'] ?? 0);
if ($customer_id <= 0) {
    header("Location: customers.php?error=ID batili");
    exit;
}

// Chukua taarifa za customer
$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $customer_id");
$customer = mysqli_fetch_assoc($result);

if (!$customer) {
    header("Location: customers.php?error=Customer haipatikani");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = !empty($_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_DEFAULT) : $customer['password'];

    if (empty($full_name) || empty($email)) {
        $error = "Jaza jina na email";
    } else {
        // Check kama email tayari imetumika na user mwingine
        $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email = '" . mysqli_real_escape_string($conn, $email) . "' AND id != $customer_id");
        if (mysqli_num_rows($check_email) > 0) {
            $error = "Email hii tayari imetumika na user mwingine";
        } else {
            $stmt = mysqli_prepare($conn, "UPDATE users SET full_name = ?, email = ?, phone = ?, password = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "ssssi", $full_name, $email, $phone, $password, $customer_id);

            if (mysqli_stmt_execute($stmt)) {
                $success = "Taarifa za customer zimehifadhiwa vizuri";
            } else {
                $error = "Tatizo la kuhifadhi: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<div class="container">
    <h1>Hariri Customer: <?= htmlspecialchars($customer['full_name']) ?></h1>

    <?php if ($success): ?>
        <p style="color:#27ae60; font-weight:bold;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p style="color:#e74c3c; font-weight:bold;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group" style="margin-bottom:15px;">
            <label>Jina Kamili *</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($customer['full_name']) ?>" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
        </div>

        <div class="form-group" style="margin-bottom:15px;">
            <label>Email *</label>
            <input type="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
        </div>

        <div class="form-group" style="margin-bottom:15px;">
            <label>Simu</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone'] ?? '') ?>" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
        </div>

        <div class="form-group" style="margin-bottom:15px;">
            <label>Nenosiri Mpya (acha tupu kama hutaki kubadilisha)</label>
            <input type="password" name="password" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
        </div>

        <button type="submit" style="background:#f39c12; color:white; padding:12px 25px; border:none; border-radius:6px; cursor:pointer;">
            Hifadhi Mabadiliko
        </button>

        <a href="customers.php" style="margin-left:15px; color:#555; text-decoration:none;">Rudi nyuma</a>
    </form>
</div>