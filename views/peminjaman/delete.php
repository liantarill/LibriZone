<?php
include '../../middlewares/auth.php';
$id = $_GET['id'];

$query = "DELETE FROM peminjaman WHERE `id` = '$id'";
$result = $conn->query($query);
header("Location: index.php");
exit();
