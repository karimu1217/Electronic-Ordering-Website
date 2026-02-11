<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
require_once '../config/database.php';
include 'header.php';
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidhaa - Kobbie Tonics</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f6f9; margin:0; padding:0; }
        .container { max-width: 1300px; margin: 30px auto; padding: 0 20px; }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 30px; }

        /* Search Bar Style */
        .search-bar {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        .search-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            max-width: 800px;
            margin: 0 auto;
        }
        .search-input {
            flex: 1;
            min-width: 200px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        .search-btn {
            background: #27ae60;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.3s;
        }
        .search-btn:hover {
            background: #219653;
        }
        .clear-search {
            background: #e74c3c;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        .clear-search:hover {
            background: #c0392b;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            text-align: center;
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .product-image-container {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            padding: 10px;
        }

        .product-image-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 8px;
        }

        .product-info {
            padding: 15px;
        }

        .product-name {
            font-size: 18px;
            margin: 10px 0;
            color: #2c3e50;
        }

        .product-price {
            font-size: 20px;
            color: #27ae60;
            font-weight: bold;
            margin: 10px 0;
        }

        .product-stock, .product-category {
            color: #555;
            font-size: 14px;
            margin: 5px 0;
        }

        .btn-add {
            background: #e67e22;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            width: 80%;
            margin: 15px auto 10px;
            display: block;
        }

        .btn-add:hover {
            background: #d35400;
        }

        /* Responsive grid */
        @media (max-width: 1024px) {
            .products-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 768px) {
            .products-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 480px) {
            .products-grid { grid-template-columns: 1fr; }
            .search-form { flex-direction: column; }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Bidhaa Zetu</h1>

    <!-- Search Bar -->
    <div class="search-bar">
        <form class="search-form" id="searchForm">
            <input type="text" id="search_name" name="search_name" class="search-input" placeholder="Tafuta jina la bidhaa (e.g. Samsung)" value="">
            <input type="text" id="search_category" name="search_category" class="search-input" placeholder="Tafuta category (e.g. Smartphones)" value="">
            <button type="submit" class="search-btn">Search</button>
            <a href="products.php" class="clear-search">Delete</a>
        </form>
    </div>

    <div class="products-grid" id="productsList">
        <!-- Bidhaa zita-load hapa kupitia JS -->
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
// Function ya addToCart (global)
function addToCart(id, name, price, image) {
    console.log('Add to cart called:', id, name, price);

    fetch('../config/api/add_to_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ product_id: id, quantity: 1 })
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error('Server error: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('API response:', data);
        if (data.success) {
            alert(name + " imeongezwa kwenye cart! 🛒");
        } else {
            alert("Tatizo: " + (data.error || 'Jaribu tena'));
        }
    })
    .catch(error => {
        console.error('Add to cart error:', error);
        alert("Tatizo la mtandao: " + error.message);
    });
}

// Function ya load products (inatumika kwa initial load na search)
function loadProducts(searchName = '', searchCategory = '') {
    const url = '../config/api/products.php' + 
                (searchName || searchCategory ? '?' : '') +
                (searchName ? 'search_name=' + encodeURIComponent(searchName) : '') +
                (searchCategory ? (searchName ? '&' : '') + 'search_category=' + encodeURIComponent(searchCategory) : '');

    fetch(url)
    .then(response => {
        if (!response.ok) {
            throw new Error('API error: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        const list = document.getElementById('productsList');
        list.innerHTML = '';

        if (data.length === 0) {
            list.innerHTML = '<p style="text-align:center; color:#666; grid-column: 1 / -1;">Hakuna bidhaa zinazolingana na tafutio lako.</p>';
            return;
        }

        data.forEach(product => {
            const div = document.createElement('div');
            div.className = 'product-card';

            let imageTag = '<p style="color:#999; font-style:italic;">Hakuna picha</p>';
            if (product.image && product.image.trim() !== '') {
                const imgPath = '/electric/' + product.image;
                imageTag = `
                    <div class="product-image-container">
                        <img src="${imgPath}" alt="${product.name}" onerror="this.src='https://via.placeholder.com/180?text=Image+Not+Found';">
                    </div>
                `;
            }

            div.innerHTML = `
                ${imageTag}
                <div class="product-info">
                    <h3 class="product-name">${product.name}</h3>
                    <p class="product-price">TZS ${Number(product.price).toLocaleString()}</p>
                    <p class="product-stock">Stock: ${product.stock}</p>
                    <p class="product-category">Category: ${product.category_name || 'Hakuna Category'}</p>
                    <button class="btn-add" onclick="addToCart(${product.id}, '${product.name.replace(/'/g, "\\'").replace(/"/g, '\\"')}', ${product.price}, '${product.image || ''}')">
                        Add Cart
                    </button>
                </div>
            `;
            list.appendChild(div);
        });
    })
    .catch(error => {
        console.error('Fetch products error:', error);
        document.getElementById('productsList').innerHTML = '<p style="text-align:center; color:red;">Tatizo la kupakua bidhaa: ' + error.message + '</p>';
    });
}

// Initial load (bidhaa zote)
loadProducts();

// Handle search form submit
document.getElementById('searchForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const searchName = document.getElementById('search_name').value.trim();
    const searchCategory = document.getElementById('search_category').value.trim();
    loadProducts(searchName, searchCategory);
});
</script>
</body>
</html>