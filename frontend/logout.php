<?php
session_start();
session_destroy(); // Futa session zote
header("Location: login.php");
exit;
?>