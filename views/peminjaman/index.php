<?php

include '../../middlewares/auth.php';
requireLogin();

$queryPeminjaman = "SELECT peminjaman.*, 
                    buku.judul AS nama_buku, 
                    anggota.nama AS nama_anggota
                    FROM peminjaman
                    JOIN buku ON peminjaman.id_buku = buku.id
                    JOIN anggota ON peminjaman.id_anggota = anggota.id";

$resultPeminjaman = mysqli_query($conn, $queryPeminjaman);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibriZone</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../public/assets/css/style.css">
</head>

<body>
    <?php include '../layouts/navbar.php' ?>

    <div class="container mx-auto my-16 px-4">
        <header class="flex justify-between items-center mb-2">
            <h1 class="items-center text-3xl font-bold text-primary ">
                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                Manajemen Peminjaman
            </h1>
            <a href="../peminjaman/add.php" class="bg-primary text-white px-4 py-2 rounded text-sm font-medium hover:bg-primary-600 transition-colors">
                + Tambah Peminjaman
            </a>
        </header>


        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded my-4">
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded my-4">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>


        <!-- Transaksi Terbaru -->
        <div class="mt-10  rounded shadow bg-white p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-500">List buku</h3>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" placeholder="Cari..."
                            class="pl-9 pr-4 py-2 border border-gray-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <button class="text-primary text-sm font-medium">Lihat Semua</button>
                </div>
            </div>

            <div class="py-7">
                <table class="w-full text-left font-medium text-xs text-gray-500 ">
                    <thead class="bg-gray-100 ">
                        <th class="px-2 py-2">ID</th>
                        <th class="px-2 py-2">PEMINJAM</th>
                        <th class="px-2 py-2">BUKU</th>
                        <th class="px-2 py-2">PINJAM</th>
                        <th class="px-2 py-2">KEMBALI</th>
                        <th class="px-2 py-2 text-center">STATUS</th>
                        <th class="px-2 py-2">AKSI</th>

                    </thead>
                    <tbody>
                        <?php
                        while ($peminjaman = mysqli_fetch_assoc($resultPeminjaman)) {
                            echo "<tr class='hover:bg-gray-50'>";
                            echo "<td class='px-2 py-2'>" . htmlspecialchars($peminjaman['id']) . "</td>";
                            echo "<td class='px-2 py-2'>" . htmlspecialchars($peminjaman['nama_anggota']) . "</td>";
                            echo "<td class='px-2 py-2'>" . htmlspecialchars($peminjaman['nama_buku']) . "</td>";
                            echo "<td class='px-2 py-2'>" . htmlspecialchars($peminjaman['tanggal_pinjam']) . "</td>";
                            echo "<td class='px-2 py-2'>" . htmlspecialchars(($peminjaman['tanggal_kembali'])) . "</td>";
                            if ($peminjaman['status_pengembalian'] === 'sudah') {
                                echo "<td class='px-2 py-2 flex justify-center'>
                                            <span class='inline-flex px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full'>Dikembalikan</span>
                                        </td>";
                            } else {
                                echo "<td class='px-2 py-2 flex justify-center'>
                                            <span class='inline-flex px-2 py-1 text-xs font-medium bg-orange-200 text-orange-700 rounded-full'>Dipinjam</span>
                                        </td>";
                            }
                            echo "<td class='px-2 py-2'>";

                            echo '<a href="edit.php?id=' . urlencode($peminjaman['id']) . '" class="text-blue-600 hover:underline">Edit</a>  ';
                            echo '<a href="delete.php?id=' . urlencode($peminjaman['id']) . '" onclick="return confirm(\'Yakin hapus?\')" class="text-red-600 hover:underline">Delete</a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>

                </table>

            </div>

        </div>



    </div>




</body>

</html>