<?php
session_start();
require_once '../config/database.php'; // connection
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingia - Kobbie Tonics</title>
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

        .login-wrapper {
            width: 100%;
            max-width: 480px;
            position: relative;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            transition: transform 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-10px);
        }

        .login-header {
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

        .login-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .login-header p {
            opacity: 0.9;
            font-size: 16px;
        }

        .login-body {
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

        .btn-login {
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

        .btn-login:hover {
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
            .login-body {
                padding: 30px 20px;
            }
            .login-header {
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

<div class="login-wrapper">
    <div class="login-card">
        <div class="login-header">
            <div class="logo-container">
                <i class="fas fa-shopping-cart" style="font-size: 50px; color: #27ae60;"></i>
            </div>

            <h1>LOGIN</h1>
            <p>Karibu tena Kobbie Tonics</p>
        </div>

        <div class="login-body">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form id="loginForm">
                <div class="form-group">
                    <label for="email">Barua Pepe</label>
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" required placeholder="mfano@gmail.com" autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Nenosiri</label>
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn-login">Ingia</button>
            </form>

            <div class="link-text">
                Hana akaunti? <a href="register.php">Jisajili hapa</a>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    if (!email || !password) {
        alert("Jaza barua pepe na nenosiri");
        return;
    }

    fetch('../config/api/login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.role === 'admin') {
                window.location.href = 'admin/dashboard.php';
            } else {
                window.location.href = 'dashboard.php';
            }
        } else {
            alert(data.error);
        }
    })
    .catch(error => {
        alert("Tatizo la mtandao: " + error);
    });
});
</script>

</body>
</html>