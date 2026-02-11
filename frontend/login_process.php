<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Jaza barua pepe na nenosiri";
        header("Location: login.php");
        exit;
    }

    $stmt = mysqli_prepare($conn, "SELECT id, full_name, role_id, password FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role_id']   = $user['role_id'];
        $_SESSION['logged_in'] = true;

        if ($user['role_id'] == 1) {
            header("Location: admin/dashboard.php"); // tutaifanya baadaye
        } else {
            header("Location: dashboard.php");       // customer dashboard
        }
        exit;
    } else {
        $_SESSION['error'] = "Barua pepe au nenosiri si sahihi";
        header("Location: login.php");
        exit;
    }
}

mysqli_close($conn);
?>