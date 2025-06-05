<?php
if (!isset($_SESSION['login'])) {
    header("Location: views/auth/login.php");
    exit;
}
