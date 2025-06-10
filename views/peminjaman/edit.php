<?php
include '../../middlewares/auth.php';
requireLogin();

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT peminjaman.*, anggota.nama as nama_anggota, buku.judul as nama_buku FROM peminjaman 
    JOIN anggota ON peminjaman.id_anggota = anggota.id 
    JOIN buku ON peminjaman.id_buku = buku.id 
    WHERE peminjaman.id = '$id'");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tidak ditemukan";
    exit;
}

if (isset($_POST['update'])) {
    $status_pengembalian = $_POST['status_pengembalian'];
    $update = mysqli_query($conn, "UPDATE peminjaman SET status_pengembalian = '$status_pengembalian' WHERE id = '$id'");
    if ($update) {
        header('Location: index.php?msg=update-success');
        exit;
    } else {
        $error = "Gagal mengupdate data.";
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

<body>
    <?php include '../layouts/navbar.php'; ?>

    <div class="min-h-screen flex items-center justify-center  my-16">
        <div class="px-4 py-6 bg-white shadow-md rounded w-full max-w-2xl">

            <?php if (isset($error)) echo "<div class='text-red-600 mb-4'>$error</div>"; ?>

            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Pengembalian</h2>
                <p class="text-gray-600">Atur status pengembalian</p>
            </div>

            <div class="p-8">
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50  shadow p-4  rounded ">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-user text-primary mr-2"></i>
                            <span class="text-sm font-semibold text-gray-600 tracking-wide">Nama Anggota</span>
                        </div>
                        <p class="text-lg font-bold text-gray-800"><?= htmlspecialchars($data['nama_anggota']) ?></p>
                    </div>

                    <div class="bg-gray-50  shadow p-4 rounded ">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-book text-primary mr-2"></i>
                            <span class="text-sm font-semibold text-gray-600 tracking-wide">Judul Buku</span>
                        </div>
                        <p class="text-lg font-bold text-gray-800"><?= htmlspecialchars($data['nama_buku']) ?></p>
                    </div>

                    <div class="bg-gray-50  shadow p-4 rounded">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-calendar-plus text-primary mr-2"></i>
                            <span class="text-sm font-semibold text-gray-600 tracking-wide">Tanggal Pinjam</span>
                        </div>
                        <p class="text-lg font-bold text-gray-800">
                            <?= date('d F Y', strtotime($data['tanggal_pinjam'])) ?>
                        </p>
                    </div>

                    <div class="bg-gray-50  shadow p-4 rounded">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-calendar-check text-primary mr-2"></i>
                            <span class="text-sm font-semibold text-gray-600 tracking-wide">Tanggal Kembali</span>
                        </div>
                        <p class="text-lg font-bold text-gray-800">
                            <?= date('d F Y', strtotime($data['tanggal_kembali'])) ?>
                        </p>
                        <?php
                        $today = date('Y-m-d');
                        $return_date = $data['tanggal_kembali'];
                        if ($today > $return_date && $data['status_pengembalian'] === 'belum'):
                        ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-2">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Terlambat
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <form method="post" class="space-y-6">
                    <div class="bg-gray-50  shadow p-6 rounded">
                        <label for="status_pengembalian" class="block text-sm font-bold text-gray-700 mb-4">
                            <i class="fas fa-clipboard-check text-primary mr-2"></i>
                            Status Pengembalian
                        </label>

                        <div class="space-y-3">
                            <div class="flex items-center p-4 border-2 border-gray-200 rounded hover:border-blue-300 transition-colors duration-200 <?= $data['status_pengembalian'] === 'belum' ? 'border-blue-500 bg-blue-50' : '' ?>">
                                <input type="radio" id="belum" name="status_pengembalian" value="belum"
                                    <?= $data['status_pengembalian'] === 'belum' ? 'checked' : '' ?>
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <label for="belum" class="ml-3 flex items-center cursor-pointer">
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-blue-500 mr-2"></i>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Dipinjam</div>
                                            <div class="text-xs text-gray-500">Buku masih dalam peminjaman</div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="flex items-center p-4 border-2 border-gray-200 rounded hover:border-green-300 transition-colors duration-200 <?= $data['status_pengembalian'] === 'sudah' ? 'border-green-500 bg-green-50' : '' ?>">
                                <input type="radio" id="sudah" name="status_pengembalian" value="sudah"
                                    <?= $data['status_pengembalian'] === 'sudah' ? 'checked' : '' ?>
                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="sudah" class="ml-3 flex items-center cursor-pointer">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Dikembalikan</div>
                                            <div class="text-xs text-gray-500">Buku sudah dikembalikan</div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="flex items-center p-4 border-2 border-gray-200 rounded hover:border-red-300 transition-colors duration-200 <?= $data['status_pengembalian'] === 'telat' ? 'border-red-500 bg-red-50' : '' ?>">
                                <input type="radio" id="telat" name="status_pengembalian" value="telat"
                                    <?= $data['status_pengembalian'] === 'telat' ? 'checked' : '' ?>
                                    class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300">
                                <label for="telat" class="ml-3 flex items-center cursor-pointer">
                                    <div class="flex items-center">
                                        <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Terlambat</div>
                                            <div class="text-xs text-gray-500">Pengembalian melewati batas waktu</div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit" name="update"
                            class="flex-1 bg-primary hover:bg-primary-dark text-white font-semibold py-4 px-6 rounded transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Perubahan
                        </button>
                        <a href="index.php"
                            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-4 px-6 rounded transition-all duration-300 text-center flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>

</body>

</html>