<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = $_POST['password'] ?? '';
    $phone     = trim($_POST['phone'] ?? '');

    if (empty($full_name) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Jaza sehemu zote muhimu";
        header("Location: register.php");
        exit;
    }

    // Check kama email tayari ipo
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '" . mysqli_real_escape_string($conn, $email) . "'");
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['error'] = "Barua pepe hii tayari imetumika";
        header("Location: register.php");
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO users (role_id, full_name, email, phone, password) VALUES (2, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $full_name, $email, $phone, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Umefanikiwa kujisajili! Sasa ingia.";
        header("Location: login.php");
    } else {
        $_SESSION['error'] = "Tatizo la kusajili: " . mysqli_error($conn);
        header("Location: register.php");
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jisajili - Kobbie Tonics</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: #333;
        }

        .register-wrapper {
            width: 100%;
            max-width: 480px;
            position: relative;
        }

        .register-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            transition: transform 0.3s ease;
        }

        .register-card:hover {
            transform: translateY(-10px);
        }

        .register-header {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 40px 30px 30px;
            text-align: center;
            position: relative;
        }

        .logo-container {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            border: 5px solid rgba(255, 255, 255, 0.3);
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        .logo-container img {
            width: 70%;
            height: 70%;
            object-fit: contain;
        }

        .register-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .register-header p {
            opacity: 0.9;
            font-size: 16px;
        }

        .register-body {
            padding: 40px 30px 30px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-group input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #27ae60;
            box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.15);
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 42px;
            color: #95a5a6;
            font-size: 18px;
        }

        .btn-register {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(39, 174, 96, 0.4);
        }

        .error-message {
            background: #ffebee;
            color: #c0392b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .link-text {
            text-align: center;
            margin-top: 25px;
            font-size: 15px;
            color: #7f8c8d;
        }

        .link-text a {
            color: #27ae60;
            font-weight: 600;
            text-decoration: none;
        }

        .link-text a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .register-body {
                padding: 30px 20px;
            }
            .register-header {
                padding: 30px 20px 20px;
            }
            .logo-container {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>

<div class="register-wrapper">
    <div class="register-card">
        <div class="register-header">
            <div class="logo-container">
                <i class="fas fa-user-plus" style="font-size: 50px; color: #27ae60;"></i>
            </div>

            <h1>Jisajili</h1>
            <p>Anza safari yako na Kobbie Tonics</p>
        </div>

        <div class="register-body">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="full_name">Jina Kamili</label>
                    <i class="fas fa-user"></i>
                    <input type="text" id="full_name" name="full_name" required placeholder="Jina lako kamili">
                </div>

                <div class="form-group">
                    <label for="email">Barua Pepe</label>
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" required placeholder="mfano@gmail.com">
                </div>

                <div class="form-group">
                    <label for="phone">Namba ya Simu (optional)</label>
                    <i class="fas fa-phone"></i>
                    <input type="tel" id="phone" name="phone" placeholder="2557xxxxxxxx">
                </div>

                <div class="form-group">
                    <label for="password">Nenosiri</label>
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn-register">Jisajili</button>
            </form>

            <div class="link-text">
                Tayari una akaunti? <a href="login.php">Ingia hapa</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>