<?php
session_start();
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
    <title>Asante kwa Kuagiza - Kobbie Tonics</title>
    <style>
        body { font-family: Arial; background:#f4f6f9; margin:0; display:flex; justify-content:center; align-items:center; min-height:100vh; }
        .thankyou-box {
            background:white; padding:50px 40px; border-radius:12px;
            box-shadow:0 4px 20px rgba(0,0,0,0.1); text-align:center; max-width:600px;
        }
        h1 { color:#27ae60; margin-bottom:20px; }
        p { font-size:18px; color:#555; margin:20px 0; }
        .order-id { font-weight:bold; color:#2c3e50; font-size:20px; }
        .btn-home { display:inline-block; background:#3498db; color:white; padding:14px 30px;
                    border-radius:6px; text-decoration:none; font-size:17px; margin-top:30px; }
        .btn-home:hover { background:#2980b9; }
    </style>
</head>
<body>

<div class="thankyou-box">
    <h1>Asante kwa Kuagiza! 🛍️</h1>
    <p>Agizo lako limefanikiwa na linashughulikiwa.</p>
    <p class="order-id">Namba ya Agizo: #<?= date('YmdHis') ?></p>
    <p>Tutakufikia Hivi Karibuni</p>

    <a href="products.php" class="btn-home">Rudi kuangalia Bidhaa zaidi</a>
</div>

</body>
</html>