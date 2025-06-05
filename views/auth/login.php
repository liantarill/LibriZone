<?php
session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: ../dashboard/index.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibriZone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="col-lg-4 card p-4">
            <h1 class="text-center">Login LibriZone</h1>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Access Ditolak!</strong> Username atau Password Salah.
                </div>
            <?php endif; ?>

            <form method="POST" action="../../middlewares/auth.php">
                <label>Username:</label><br>
                <input type="text" name="username"><br><br>

                <label>Password:</label><br>
                <input type="password" name="password"><br><br>

                <button type="submit" name="login">Login</button>

            </form>
        </div>
    </div>

</body>

</html>