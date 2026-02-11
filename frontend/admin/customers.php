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
    <h1>Wateja Wangu</h1>

    <?php if (isset($_GET['msg'])): ?>
        <p style="color:#27ae60; font-weight:bold;"><?php echo htmlspecialchars($_GET['msg']); ?></p>
    <?php endif; ?>

    <table style="width:100%; border-collapse:collapse; margin-top:20px;">
        <tr style="background:#34495e; color:white;">
            <th style="padding:12px;">ID</th>
            <th style="padding:12px;">Jina</th>
            <th style="padding:12px;">Email</th>
            <th style="padding:12px;">Simu</th>
            <th style="padding:12px;">Tarehe Aliyejisajili</th>
            <th style="padding:12px;">Chaguzi</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM users WHERE role_id = 2 ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr style='border-bottom:1px solid #ddd;'>";
            echo "<td style='padding:12px;'>{$row['id']}</td>";
            echo "<td style='padding:12px;'>" . htmlspecialchars($row['full_name']) . "</td>";
            echo "<td style='padding:12px;'>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td style='padding:12px;'>" . htmlspecialchars($row['phone'] ?? '-') . "</td>";
            echo "<td style='padding:12px;'>" . $row['created_at'] . "</td>";
            echo "<td style='padding:12px;'>
                <a href='edit_customer.php?id={$row['id']}' style='background:#f39c12; color:white; padding:8px 12px; border-radius:5px; text-decoration:none; margin-right:5px;'>Hariri</a>
                <a href='delete_customer.php?id={$row['id']}' onclick='return confirm(\"Hakikisha unataka kufuta customer hii?\")' style='background:#e74c3c; color:white; padding:8px 12px; border-radius:5px; text-decoration:none;'>Futa</a>
            </td>";
            echo "</tr>";
        }
        mysqli_close($conn);
        ?>
    </table>
</div>