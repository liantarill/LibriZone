<?php
include '../../middlewares/auth.php';
requireLogin();

$id = $_GET['id'];

$query = "DELETE FROM `buku` WHERE `id` = '$id'";
$result = $conn->query($query);
header("Location: index.php");
exit();
