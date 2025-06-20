<?php

include '../../middlewares/auth.php';
requireLogin();
$queryBuku =    "SELECT buku.*, kategori.nama_kategori 
                FROM buku 
                JOIN kategori ON buku.id_kategori = kategori.id";
$resultBuku = mysqli_query($conn, $queryBuku);

$queryDipinjam =    "SELECT id_buku, COUNT(*) AS jumlah_dipinjam 
                    FROM peminjaman 
                    WHERE status_pengembalian = 'belum' 
                    GROUP BY id_buku";
$resultDipinjam = mysqli_query($conn, $queryDipinjam);


$jumlahDipinjam = [];
while ($row = mysqli_fetch_assoc($resultDipinjam)) {
    $jumlahDipinjam[$row['id_buku']] = $row['jumlah_dipinjam'];
}

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
                <i class="fas fa-book text-primary mr-3"></i>
                Manajemen Buku
            </h1>
            <a href="add.php" class="bg-primary text-white px-4 py-2 rounded text-sm font-medium hover:bg-primary-600 transition-colors">
                + Tambah Buku
            </a>
        </header>
        <?php if (isset($_GET['success'])): ?>
            <div class="my-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-green-400 mr-3"></i>
                    <p class="text-green-700 font-medium"><?php echo htmlspecialchars($_GET['success']); ?></p>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-400 mr-3"></i>
                    <p class="text-red-700 font-medium"><?php echo htmlspecialchars($_GET['error']); ?></p>
                </div>
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
                    <thead class="bg-gray-100">
                        <th class="px-2 py-2">ID</th>
                        <th class="px-2 py-2">JUDUL</th>
                        <th class="px-2 py-2">PENULIS</th>
                        <th class="px-2 py-2">PENERBIT</th>
                        <th class="px-2 py-2">KATEGORI</th>
                        <th class="px-2 py-2">TAHUN TERBIT</th>
                        <th class="px-2 py-2">JUMLAH</th>
                        <th class="px-2 py-2">AKSI</th>
                    </thead>
                    <tbody>
                        <?php
                        while ($book = mysqli_fetch_assoc($resultBuku)) {
                            $dipinjam = $jumlahDipinjam[$book['id']] ?? 0;
                            $tersedia = $book['jumlah'] - $dipinjam;

                            echo "<tr class='hover:bg-gray-50 border-b'>";
                            echo "<td class='px-2 py-2'>" . htmlspecialchars($book['id']) . "</td>";
                            echo "<td class='px-2 py-2'>" . htmlspecialchars($book['judul']) . "</td>";
                            echo "<td class='px-2 py-2'>" . htmlspecialchars($book['penulis']) . "</td>";
                            echo "<td class='px-2 py-2'>" . htmlspecialchars($book['penerbit']) . "</td>";
                            echo "<td class='px-2 py-2'>" . htmlspecialchars($book['nama_kategori']) . "</td>";
                            echo "<td class='px-2 py-2'>" . htmlspecialchars($book['tahun_terbit']) . "</td>";
                            echo "<td class='px-2 py-2'>" . htmlspecialchars($tersedia) . "</td>";
                            echo "<td class='px-2 py-2'>";
                            echo '<a href="edit.php?id=' . urlencode($book['id']) . '" class="text-blue-600 hover:underline">Edit</a> ';
                            echo '<a href="delete.php?id=' . urlencode($book['id']) . '" onclick="return confirm(\'Yakin hapus?\')" class="text-red-600 hover:underline">Delete</a>';
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