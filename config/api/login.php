<?php
header('Content-Type: application/json');
require_once '../database.php';
session_start();

$input = json_decode(file_get_contents('php://input'), true);

$email = trim($input['email'] ?? '');
$password = $input['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'error' => 'Jaza barua pepe na nenosiri']);
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT id, full_name, role_id, password FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['role_id'] = $user['role_id'];
    $_SESSION['logged_in'] = true;

    echo json_encode(['success' => true, 'role' => $user['role_id'] == 1 ? 'admin' : 'customer']);
} else {
    echo json_encode(['success' => false, 'error' => 'Barua pepe au nenosiri si sahihi']);
}
mysqli_close($conn);
?>