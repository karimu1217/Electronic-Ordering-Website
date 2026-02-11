<header class="header">
    <!-- Logo kushoto na blinking effect -->
    <div class="logo">
        <h1 class="brand-blink">KOBBIE TONICS</h1>
    </div>

    <!-- Navbar links kulia -->
    <nav class="nav-links">
        <a href="../index.php">Home</a>
        <a href="products.php">Our Products</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact / Location</a>

        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <!-- Links za logged-in user -->
            <a href="cart.php" class="nav-btn cart-btn">Cart</a>
            <a href="checkout.php" class="nav-btn checkout-btn">Checkout</a>
            <a href="orders.php" class="nav-btn orders-btn">Orders</a>
            <a href="logout.php" class="logout-btn">Logout (<?= htmlspecialchars($_SESSION['full_name'] ?? 'Mteja') ?>)</a>
        <?php else: ?>
            <!-- Links za guest -->
            <a href="login.php" class="login-btn">Login</a>
            <a href="register.php" class="signup-btn">Register</a>
        <?php endif; ?>
    </nav>
</header>

<style>
    .header {
        background: linear-gradient(135deg, #1e3c72 0%, #2c3e50 100%);
        color: white;
        padding: 18px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.4);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .logo .brand-blink {
        margin: 0;
        font-size: 32px;
        font-weight: 900;
        letter-spacing: 4px;
        background: linear-gradient(90deg, #27ae60, #2ecc71, #27ae60, #00ff88);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 300% auto;
        animation: colorBlink 4s ease-in-out infinite;
        text-shadow: 0 0 15px rgba(39, 174, 96, 0.7), 0 0 30px rgba(39, 174, 96, 0.4);
    }

    @keyframes colorBlink {
        0%   { background-position: 0% 50%; opacity: 0.9; }
        25%  { background-position: 100% 50%; opacity: 1; }
        50%  { background-position: 0% 50%; opacity: 0.85; }
        75%  { background-position: 100% 50%; opacity: 1; }
        100% { background-position: 0% 50%; opacity: 0.9; }
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 35px;
    }

    .nav-links a {
        color: #ffffff;
        text-decoration: none;
        font-weight: 600;
        font-size: 17px;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-links a:hover {
        color: #27ae60;
        transform: translateY(-2px);
    }

    /* Buttons style */
    .nav-btn, .login-btn, .signup-btn, .logout-btn {
        padding: 10px 22px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 16px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .cart-btn     { background: #e67e22; color: white; }
    .cart-btn:hover     { background: #d35400; transform: scale(1.05); }

    .checkout-btn { background: #27ae60; color: white; }
    .checkout-btn:hover { background: #219653; transform: scale(1.05); }

    .orders-btn   { background: #3498db; color: white; }
    .orders-btn:hover   { background: #2980b9; transform: scale(1.05); }

    .login-btn    { background: #3498db; color: white; }
    .login-btn:hover    { background: #2980b9; transform: scale(1.05); }

    .signup-btn   { background: #8e44ad; color: white; }
    .signup-btn:hover   { background: #732d91; transform: scale(1.05); }

    .logout-btn   { background: #e74c3c; color: white; }
    .logout-btn:hover   { background: #c0392b; transform: scale(1.05); }

    /* Responsive */
    @media (max-width: 768px) {
        .header {
            padding: 15px 20px;
            flex-direction: column;
            gap: 15px;
        }

        .logo .brand-blink {
            font-size: 24px;
            letter-spacing: 2px;
        }

        .nav-links {
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            text-align: center;
        }

        .nav-links a, .nav-btn, .login-btn, .signup-btn, .logout-btn {
            padding: 8px 16px;
            font-size: 14px;
        }
    }
</style>