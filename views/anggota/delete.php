<?php
include '../../middlewares/auth.php';
$id = $_GET['id'];

// $query = "DELETE FROM anggota WHERE id = '$id'";
// $result = $conn->query($query);

// $conn->query("DELETE FROM peminjaman WHERE id_anggota = $id");
$conn->query("DELETE FROM anggota WHERE id = $id");
header("Location: index.php");
exit();
