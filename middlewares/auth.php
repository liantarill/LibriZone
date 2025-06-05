<?php
session_start();
include __DIR__ . '/../config/db.php';


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $queryUser = "SELECT * FROM admin WHERE username = '$username'";
    $resultUser = mysqli_query($conn, $queryUser);
    $user = mysqli_fetch_assoc($resultUser);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['id'] = (int) $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'] ?? 'admin';

        header("Location: ../views/dashboard/index.php");
        exit;

        exit;
    } else {
        header("Location: ../views/auth/login.php?error=1");
        exit;
    }
}


function requireLogin()
{
    if (!isset($_SESSION['username'])) {
        header("Location: ../auth/login.php");
        exit();
    }
}
