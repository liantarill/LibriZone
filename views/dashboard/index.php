<?php
include '../../middlewares/auth.php';
requireLogin();

$queryBuku = "SELECT * FROM buku";
$resultBuku = mysqli_query($conn, $queryBuku);
$totalBuku = mysqli_num_rows($resultBuku);

$queryAnggota = "SELECT * FROM anggota";
$resultAnggota = mysqli_query($conn, $queryAnggota);
$totalAnggota = mysqli_num_rows($resultAnggota);



$queryDipinjam = "SELECT * FROM buku WHERE status = 'dipinjam'";
$resultDipinjam = mysqli_query($conn, $queryDipinjam);
$totalDipinjam = mysqli_num_rows($resultDipinjam);


$queryPeminjaman = "SELECT peminjaman.*, 
                    buku.judul AS nama_buku, 
                    anggota.nama AS nama_anggota
                    FROM peminjaman
                    JOIN buku ON peminjaman.id_buku = buku.id
                    JOIN anggota ON peminjaman.id_anggota = anggota.id
                    LIMIT 7";

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
                Selamat Datang di LibriZone
            </h1>
            <a href="../peminjaman/add.php" class="bg-primary text-white px-4 py-2 rounded text-sm font-medium hover:bg-primary-600 transition-colors">
                + Tambah Peminjaman
            </a>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-10">
            <div class="bg-white shadow p-4 rounded">
                <div class="flex justify-between items-center mb-2">
                    <h6 class="text-gray-500 text-sm">Total Buku</h6>
                    <div class="text-primary flex items-center justify-center bg-primary-200 rounded-full w-10 h-10  ">
                        <i class="fa-solid fa-book"></i>
                    </div>
                </div>
                <p class="text-2xl font-bold"><?= $totalBuku ?></p>
            </div>

            <div class="bg-white shadow p-4 rounded">
                <div class="flex justify-between items-center mb-2">
                    <h6 class="text-gray-500 text-sm">Buku Dipinjam</h6>
                    <div class="text-primary flex items-center justify-center bg-primary-200 rounded-full w-10 h-10  ">
                        <i class="fa-regular fa-bookmark"></i>
                    </div>
                </div>
                <p class="text-2xl font-bold"><?= $totalDipinjam ?></p>
            </div>

            <div class="bg-white shadow p-4 rounded">
                <div class="flex justify-between items-center mb-2">
                    <h6 class="text-gray-500 text-sm">Total Anggota</h6>
                    <div class="text-primary flex items-center justify-center bg-primary-200 rounded-full w-10 h-10  ">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <p class="text-2xl font-bold"><?= $totalAnggota ?></p>
            </div>

            <div class="bg-white shadow p-4 rounded">
                <div class="flex justify-between items-center mb-2">
                    <h6 class="text-gray-500 text-sm">Total Buku</h6>
                    <div class="text-primary flex items-center justify-center bg-primary-200 rounded-full w-10 h-10  ">
                        <i class="fa-solid fa-book"></i>
                    </div>
                </div>
                <p class="text-2xl font-bold"><?= $totalBuku ?></p>
            </div>
        </div>


        <div class="grid  lg:grid-cols-4 lg:gap-8 mt-10">

            <!-- Transaksi Terbaru -->
            <div class="col-span-3  rounded shadow bg-white p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-500">Transaksi Terbaru</h3>
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="text" placeholder="Cari..."
                                class="pl-9 pr-4 py-2 border border-gray-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <a href="../peminjaman/index.php" class="text-primary text-sm font-medium">Lihat Semua</a>
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


            <div class="shadow p-6">
                <h3 class="font-bold mb-4 text-gray-500">Aksi Cepat</h3>
                <div class="flex flex-col gap-y-3">
                    <a href="../buku/add.php" class="border text-center border-primary rounded text-primary hover:text-white hover:bg-primary transition duration-200 text-sm w-full py-2">
                        <i class="fa-solid fa-book"></i>
                        Tambah buku
                    </a>
                    <a href="../anggota/add.php" class="border text-center border-primary rounded text-primary hover:text-white hover:bg-primary transition duration-200 text-sm w-full py-2">
                        <i class="fa-solid fa-user-plus"></i>
                        Tambah anggota
                    </a>
                    <a href="../peminjaman/add.php" class="border text-center border-primary rounded text-primary hover:text-white hover:bg-primary transition duration-200 text-sm w-full py-2">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        Catat peminjaman
                    </a>
                    <button class="border text-center border-primary rounded text-primary hover:text-white hover:bg-primary transition duration-200 text-sm w-full py-2">
                        <i class="fa-solid fa-hands-bound"></i>
                        Catat pengembalian
                    </button>
                </div>
            </div>


        </div>
    </div>




</body>

</html>