<?php
session_start();
include("header.php");
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php?redirect=checkout");
    exit;
}
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Kobbie Tonics</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f6f9; margin:0; }
        .header { background:#2c3e50; color:white; padding:15px 30px; display:flex; justify-content:space-between; align-items:center; }
        .container { max-width:1000px; margin:30px auto; padding:0 20px; }
        h1 { text-align:center; color:#2c3e50; margin-bottom:30px; }
        .checkout-grid { display:grid; grid-template-columns:1fr 1fr; gap:40px; }
        .cart-section { background:white; padding:25px; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.08); }
        .cart-item { display:flex; align-items:center; gap:20px; border-bottom:1px solid #eee; padding:15px 0; }
        .cart-item img { width:100px; height:100px; object-fit:contain; border:1px solid #ddd; border-radius:6px; }
        .item-details { flex:1; }
        .total { font-size:22px; font-weight:bold; text-align:right; margin-top:20px; color:#27ae60; }
        .form-section { background:white; padding:25px; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.08); }
        .form-group { margin-bottom:20px; }
        label { display:block; margin-bottom:8px; font-weight:bold; color:#555; }
        input, textarea, select { width:100%; padding:12px; border:1px solid #ddd; border-radius:6px; font-size:16px; }
        .btn-confirm { width:100%; padding:16px; background:#27ae60; color:white; border:none; border-radius:6px; font-size:18px; font-weight:bold; cursor:pointer; margin-top:20px; }
        .btn-confirm:hover { background:#219653; }
        .success-msg { background:#d4edda; color:#155724; padding:20px; border-radius:8px; text-align:center; margin:20px 0; display:none; }
        @media (max-width:768px) { .checkout-grid { grid-template-columns:1fr; } }
    </style>
</head>
<body>

<div class="container">
    <h1>Checkout</h1>

    <div class="checkout-grid">
        <!-- Cart Summary -->
        <div class="cart-section">
            <h2>Bidhaa Zako</h2>
            <div id="cartItems">Loading cart...</div>
            <div class="total">Jumla: TZS <span id="cartTotal">0.00</span></div>
        </div>

        <!-- Checkout Form -->
        <div class="form-section">
            <h2>Taarifa za Usafirishaji</h2>
            <form id="checkoutForm">
                <div class="form-group">
                    <label>Jina Kamili *</label>
                    <input type="text" name="full_name" required value="<?= htmlspecialchars($_SESSION['full_name'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Anwani Kamili *</label>
                    <textarea name="address" rows="3" required placeholder="Mtaa, Jiji, Nchi..."></textarea>
                </div>

                <div class="form-group">
                    <label>Namba ya Simu *</label>
                    <input type="tel" name="phone" required placeholder="2557xxxxxxxx">
                </div>

                <div class="form-group">
                    <label>Njia ya Malipo</label>
                    <select name="payment_method" required>
                        <option value="cash_on_delivery">Malipo wakati wa kusafirishwa (COD)</option>
                        <option value="mpesa">M-Pesa</option>
                        <option value="yas">MixxbyYass</option>
                        <option value="halopesa">Halopesa</option>
                        <option value="airtel">Airtel Money</option>
                    </select>
                </div>

                <button type="submit" class="btn-confirm">Thibitisha Agizo</button>
            </form>

            <div id="successMsg" class="success-msg">
                Agizo lako limefanikiwa! Tutakufikia hivi karibuni. 🛍️<br>
                <a href="products.php" style="color:#27ae60; font-weight:bold;">Rudi kuangalia bidhaa zaidi</a>
            </div>
        </div>
    </div>
</div>

<script>
let cartItems = [];

function loadCart() {
    fetch('/electric/config/api/cart.php')  // absolute path - badilisha /kobbie-tonics/ kama folder yako ni electric au nyingine
    .then(response => {
        console.log('Cart API status:', response.status); // debug
        if (!response.ok) {
            throw new Error('API error: ' + response.status + ' - ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        console.log('Cart data received:', data); // debug - angalia console
        cartItems = data.items || [];

        const container = document.getElementById('cartItems');
        container.innerHTML = '';

        if (cartItems.length === 0) {
            container.innerHTML = '<p style="text-align:center; color:#666;">Cart yako iko tupu.</p>';
            document.getElementById('cartTotal').textContent = '0.00';
            return;
        }

        let total = 0;
        cartItems.forEach(item => {
            total += item.price * item.quantity;
            const div = document.createElement('div');
            div.className = 'cart-item';
            div.innerHTML = `
                <img src="/electric/${item.image}" alt="${item.name}" width="100">
                <div class="item-details">
                    <h3>${item.name}</h3>
                    <p>TZS ${Number(item.price).toLocaleString()} x ${item.quantity}</p>
                    <p>Jumla: TZS ${(item.price * item.quantity).toLocaleString()}</p>
                </div>
            `;
            container.appendChild(div);
        });

        document.getElementById('cartTotal').textContent = total.toLocaleString();
    })
    .catch(err => {
        console.error('Full cart load error:', err);
        document.getElementById('cartItems').innerHTML = '<p style="color:red;">Tatizo la kupakua cart: ' + err.message + '</p>';
        alert('Tatizo la kupakua cart: ' + err.message + '\nCheck console (F12)');
    });
}

document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();

    if (cartItems.length === 0) {
        alert("Cart yako iko tupu!");
        return;
    }

    const paymentMethod = document.querySelector('[name="payment_method"]').value;
    const full_name = document.querySelector('[name="full_name"]').value;
    const address = document.querySelector('[name="address"]').value;
    const phone = document.querySelector('[name="phone"]').value;

    // M-Pesa simulation
    if (paymentMethod === 'mpesa') {
        const total = document.getElementById('cartTotal').textContent.replace(/,/g, '');
        const phonePrompt = prompt("Weka namba yako ya M-Pesa (e.g. 2557xxxxxxxx):", phone);

        if (!phonePrompt || phonePrompt.length < 12) {
            alert("Namba si sahihi! Jaribu tena.");
            return;
        }

        alert(`Tuma TZS ${parseFloat(total).toLocaleString()} kwa M-Pesa kwa namba hii:\n\n` +
              `Namba: 0792 600 353\n` +
              `Jina: Kobbie Tonics Ltd\n` +
              `Maelezo: Agizo #${Date.now()}\n\n` +
              `Baada ya kutuma, bonyeza OK ili kuthibitisha.`);
    }

    // Save order
    fetch('/electric/config/api/create_order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            items: cartItems,
            total: parseFloat(document.getElementById('cartTotal').textContent.replace(/,/g, '')),
            full_name: full_name,
            address: address,
            phone: phone,
            payment_method: paymentMethod
        })
    })
    .then(res => {
        console.log('Create order status:', res.status); // debug
        if (!res.ok) {
            throw new Error('Server error: ' + res.status);
        }
        return res.json();
    })
    .then(data => {
        console.log('Create order response:', data); // debug
        if (data.success) {
            const successMsg = document.getElementById('successMsg');
            successMsg.style.display = 'block';

            fetch('/electric/config/api/clear_cart.php', { method: 'POST' });
            setTimeout(() => window.location.href = 'thankyou.php', 3000);
        } else {
            alert("Tatizo la kuhifadhi agizo: " + (data.error || 'Jaribu tena'));
        }
    })
    .catch(err => {
        console.error('Create order error:', err);
        alert("Tatizo la mtandao wakati wa kuthibitisha: " + err.message);
    });
});

loadCart();
 // Load cart wakati page inafunguliwa
</script>
<?php include("footer.php"); ?>