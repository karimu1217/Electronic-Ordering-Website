<?php
session_start();
 include("header.php"); 
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
    <title>Cart - Kobbie Tonics</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f6f9; margin:0; }
        .header { background:#2c3e50; color:white; padding:15px 30px; display:flex; justify-content:space-between; align-items:center; }
        .container { max-width:900px; margin:30px auto; padding:20px; background:white; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.1); }
        h1 { text-align:center; color:#2c3e50; margin-bottom:30px; }
        .cart-empty { text-align:center; color:#666; padding:50px 0; font-size:18px; }
        .cart-item { display:flex; align-items:center; gap:20px; border-bottom:1px solid #eee; padding:15px 0; }
        .cart-item img { width:120px; height:120px; object-fit:contain; border:1px solid #ddd; border-radius:6px; }
        .item-details { flex:1; }
        .quantity-controls { display:flex; align-items:center; gap:8px; margin:10px 0; }
        .btn-qty { width:32px; height:32px; background:#ecf0f1; border:none; border-radius:4px; font-size:18px; cursor:pointer; }
        .qty-display { width:40px; text-align:center; font-weight:bold; }
        .btn-remove { background:#e74c3c; color:white; border:none; padding:8px 16px; border-radius:5px; cursor:pointer; font-size:14px; }
        .btn-remove:hover { background:#c0392b; }
        .total { text-align:right; font-size:22px; font-weight:bold; margin:30px 0; color:#27ae60; }
        .btn-checkout { display:block; width:250px; margin:0 auto; padding:14px; background:#27ae60; color:white; text-align:center; text-decoration:none; border-radius:6px; font-size:17px; }
        .btn-checkout:hover { background:#219653; }
    </style>
</head>
<body>

<div class="container">
    <h1>Cart</h1>

    <div id="cartItems">Loading cart...</div>

    <div class="total">Jumla: TZS <span id="cartTotal">0.00</span></div>
    <a href="checkout.php" class="btn-checkout">Endelea na Malipo</a>
</div>

<script>
// 1. Function ya updateCartCount (iwe kwanza ili iwe accessible)
function updateCartCount() {
    fetch('../config/api/cart_count.php')
    .then(res => res.json())
    .then(data => {
        const badge = document.getElementById('cartCount');
        if (badge) {
            badge.textContent = data.count || 0;
            badge.style.display = data.count > 0 ? 'inline-block' : 'none';
        }
    })
    .catch(err => console.error('Cart count error:', err));
}

// 2. Function ya loadCart (inayoitwa updateCartCount baada ya load)
function loadCart() {
    fetch('../config/api/cart.php')
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('cartItems');
        container.innerHTML = '';

        if (data.items.length === 0) {
            container.innerHTML = '<p class="cart-empty">Cart yako iko tupu. <br><a href="products.php">Angalia bidhaa</a></p>';
            document.getElementById('cartTotal').textContent = '0.00';
            updateCartCount();
            return;
        }

        let total = 0;
        data.items.forEach(item => {
            total += item.price * item.quantity;
            const div = document.createElement('div');
            div.className = 'cart-item';
            div.innerHTML = `
                <img src="/electric/${item.image}" alt="${item.name}">
                <div class="item-details">
                    <h3>${item.name}</h3>
                    <p>TZS ${Number(item.price).toLocaleString()}</p>
                    <div class="quantity-controls">
                        <button class="btn-qty" onclick="updateQuantity(${item.cart_item_id}, -1)">-</button>
                        <span class="qty-display">${item.quantity}</span>
                        <button class="btn-qty" onclick="updateQuantity(${item.cart_item_id}, 1)">+</button>
                    </div>
                    <p>Jumla: TZS ${(item.price * item.quantity).toLocaleString()}</p>
                    <button class="btn-remove" onclick="removeItem(${item.cart_item_id})">Ondoa</button>
                </div>
            `;
            container.appendChild(div);
        });

        document.getElementById('cartTotal').textContent = total.toLocaleString();
        updateCartCount(); // update navbar count
    })
    .catch(err => {
        console.error('Cart load error:', err);
        document.getElementById('cartItems').innerHTML = '<p>Tatizo la kupakua cart: ' + err.message + '</p>';
    });
}

// 3. Functions za update quantity na remove (ziwe nje pia)
function updateQuantity(cartItemId, change) {
    fetch('../config/api/update_cart_item.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ item_id: cartItemId, change: change })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            loadCart(); // reload cart
        } else {
            alert(data.error || 'Tatizo');
        }
    })
    .catch(err => alert('Tatizo la mtandao'));
}

function removeItem(cartItemId) {
    if (confirm('Ondoa bidhaa hii?')) {
        fetch('../config/api/remove_cart_item.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ item_id: cartItemId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                loadCart(); // reload
            } else {
                alert(data.error || 'Tatizo');
            }
        })
        .catch(err => alert('Tatizo la mtandao'));
    }
}

// 4. Load cart wakati page inafunguliwa
document.addEventListener('DOMContentLoaded', function() {
    loadCart();
    updateCartCount(); 
});
</script>
<?php include("footer.php"); ?>