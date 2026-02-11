<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role_id'] != 1) {
    header("Location: ../../login.php");
    exit;
}
require_once '../../config/database.php';
include 'admin_header.php';
?>
<div class="container">
    <h1>Simamia Categories</h1>
    <a href="add_category.php" style="background:#27ae60; color:white; padding:12px 20px; border-radius:6px; text-decoration:none; display:inline-block; margin-bottom:20px;">+ Ongeza Category Mpya</a>

    <table style="width:100%; border-collapse:collapse;">
        <tr style="background:#34495e; color:white;">
            <th style="padding:12px;">ID</th>
            <th style="padding:12px;">Jina</th>
            <th style="padding:12px;">Maelezo</th>
            <th style="padding:12px;">Tarehe</th>
            <th style="padding:12px;">Chaguzi</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr style='border-bottom:1px solid #ddd;'>";
            echo "<td style='padding:12px;'>{$row['id']}</td>";
            echo "<td style='padding:12px;'>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td style='padding:12px;'>" . htmlspecialchars($row['description'] ?? '-') . "</td>";
            echo "<td style='padding:12px;'>" . $row['created_at'] . "</td>";
            echo "<td style='padding:12px;'>
                <a href='edit_category.php?id={$row['id']}' style='background:#f39c12; color:white; padding:8px 12px; border-radius:5px; text-decoration:none; margin-right:5px;'>Hariri</a>
                <a href='delete_category.php?id={$row['id']}' onclick='return confirm(\"Hakikisha unataka kufuta?\")' style='background:#e74c3c; color:white; padding:8px 12px; border-radius:5px; text-decoration:none;'>Futa</a>
            </td>";
            echo "</tr>";
        }
        mysqli_close($conn);
        ?>
    </table>
</div>