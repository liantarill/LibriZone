<?php
session_start();

if (isset($_SESSION['username'])) {
    header('Location: ../views/dashboard/index.php');
    exit();
} else {
    header('Location: ../views/auth/login.php');
    exit();
}
