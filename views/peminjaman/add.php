<?php

include '../../middlewares/auth.php';
requireLogin();

if (isset($_POST['add'])) {
    $id_anggota = $_POST['id_anggota'];
    $id_buku = $_POST['id_buku'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    // Cek jumlah tersedia dulu
    $cek = mysqli_query($conn, "SELECT jumlah FROM buku WHERE id = '$id_buku'");
    $data = mysqli_fetch_assoc($cek);

    $queryPinjam = mysqli_query($conn, "SELECT COUNT(*) as dipinjam 
        FROM peminjaman 
        WHERE id_buku = '$id_buku' AND status_pengembalian = 'belum'");
    $row = mysqli_fetch_assoc($queryPinjam);

    $tersedia = $data['jumlah'] - $row['dipinjam'];
    if ($tersedia > 0) {
        $insert = mysqli_query($conn, "INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, tanggal_kembali, status_pengembalian)
        VALUES ('$id_anggota', '$id_buku', '$tanggal_pinjam', '$tanggal_kembali', 'belum')");
        if ($insert) {
            header("Location: index.php?success=Peminjaman berhasil.");
            exit;
        } else {
            header("Location: index.php?error=Gagal menyimpan data.");
            exit;
        }
    } else {
        header("Location: index.php?error=Stok buku tidak tersedia.");
        exit;
    }
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

<body class="min-h-screen bg-gray-50">
    <?php include '../layouts/navbar.php' ?>

    <div class="min-h-screen flex items-center justify-center">
        <div class="px-4 py-6 bg-white shadow-md rounded w-full max-w-2xl">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Form Peminjaman Buku</h2>
                <p class="text-gray-600">Silakan isi data peminjaman buku di bawah ini</p>
            </div>

            <form method="post" class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Anggota</label>
                    <select name="id_anggota" required
                        class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-primary focus:border-primary bg-white shadow-sm">
                        <option value="">Pilih Anggota</option>
                        <?php
                        $anggota = mysqli_query($conn, "SELECT id, nama FROM anggota");
                        while ($a = mysqli_fetch_assoc($anggota)) {
                            echo "<option value='" . $a['id'] . "'>" . htmlspecialchars($a['nama']) . " (ID: " . $a['id'] . ")</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Buku</label>
                    <select name="id_buku" required
                        class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-primary focus:border-primary bg-white shadow-sm">
                        <option value="">Pilih Buku</option>
                        <?php
                        $buku = mysqli_query($conn, "SELECT id, judul FROM buku");
                        while ($b = mysqli_fetch_assoc($buku)) {
                            echo "<option value='" . $b['id'] . "'>" . htmlspecialchars($b['judul']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pinjam
                        </label>
                        <input type="date" name="tanggal_pinjam" required
                            class="w-full px-4 py-3 border border-gray-300 rounded  focus:outline-primary focus:border-primary  shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Kembali
                        </label>
                        <input type="date" name="tanggal_kembali" required
                            class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-primary focus:border-primary shadow-sm">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <button name="add" type="submit"
                        class="flex-1 bg-primary hover:bg-primary-600 text-white font-semibold py-3 px-6 rounded transition duration-300  shadow-lg">
                        <i class="fas fa-save mr-2"></i>Simpan Data Peminjaman
                    </button>
                    <a href="index.php"
                        class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded transition duration-300 text-center">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>


    </div>

</body>

</html>