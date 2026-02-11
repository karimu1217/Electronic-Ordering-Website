<?php
session_start();
include 'header.php';
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<div class="container">
    <h1>Maagizo Yangu</h1>
    <p>Hakuna maagizo yaliyopatikana kwa sasa. Agiza bidhaa kwenye <a href="products.php">Bidhaa</a>.</p>
</div>
<?php include("footer.php"); ?>