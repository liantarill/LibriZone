<?php
include '../../middlewares/auth.php';
requireLogin();

if (isset($_POST['add'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun_terbit = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);

    // Validasi input
    if (empty($judul) || empty($penulis) || empty($penerbit) || empty($tahun_terbit) || empty($id_kategori) || empty($status) || empty($jumlah)) {
        header("Location: add.php?error=Semua field harus diisi.");
        exit;
    }

    $insert = mysqli_query($conn, "INSERT INTO `buku`(`judul`, `penulis`, `penerbit`, `tahun_terbit`, `id_kategori`, `status`, `jumlah`) 
                                    VALUES ('$judul','$penulis','$penerbit','$tahun_terbit','$id_kategori','$status','$jumlah')");

    if ($insert) {
        header("Location: index.php?success=Buku berhasil ditambahkan.");
        exit;
    } else {
        header("Location: add.php?error=Gagal menambahkan buku.");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibriZone</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../public/assets/css/style.css">
</head>

<body class="min-h-screen flex items-center justify-center">
    <?php include '../layouts/navbar.php' ?>
    <div class="container mx-auto my-16 ">
        <div class="max-w-2xl mx-auto">

            <div class="bg-white rounded shadow-lg px-4 py-6">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Tambah Buku</h2>
                    <p class="text-gray-600">Lengkapi informasi buku yang akan ditambahkan ke perpustakaan</p>
                </div>

                <div class="p-8">
                    <form method="post" class="space-y-6">
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700">Judul Buku</label>
                            <input type="text" name="judul" required
                                class="w-full px-4 py-3 border border-gray-300 rounded  focus:outline-primary focus:border-primary transition duration-200 bg-white shadow-sm"
                                placeholder="Masukkan judul buku">
                        </div>

                        <div class="space-y-">
                            <label class="block text-sm font-semibold text-gray-700">Penulis
                            </label>
                            <input type="text" name="penulis" required
                                class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-primary focus:border-primary transition duration-200 bg-white shadow-sm"
                                placeholder="Masukkan nama penulis">
                        </div>

                        <div class="space-y-">
                            <label class="block text-sm font-semibold text-gray-700">Penerbit</label>
                            <input type="text" name="penerbit" required
                                class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-primary focus:border-primary transition duration-200 bg-white shadow-sm"
                                placeholder="Masukkan nama penerbit">
                        </div>

                        <div class="space-y-">
                            <label class="block text-sm font-semibold text-gray-700">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" required min="1900" max="<?php echo date('Y'); ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-primary focus:border-primary transition duration-200 bg-white shadow-sm"
                                placeholder="Contoh: 2023">
                        </div>

                        <div class="space-y-">
                            <label class="block text-sm font-semibold text-gray-700">Kategori</label>
                            <select name="id_kategori" required
                                class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-primary focus:border-primary transition duration-200 bg-white shadow-sm">
                                <option value="">Pilih Kategori</option>
                                <?php
                                $kategori = mysqli_query($conn, "SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori");
                                while ($k = mysqli_fetch_assoc($kategori)) {
                                    echo "<option value='" . $k['id'] . "'>" . htmlspecialchars($k['nama_kategori']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-">
                                <label class="block text-sm font-semibold text-gray-700">Status</label>
                                <select name="status" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded focus:outline-primary focus:border-primary transition duration-200 bg-white shadow-sm">
                                    <option value="">Pilih Status</option>
                                    <option value="tersedia">Tersedia</option>
                                    <option value="tidak tersedia">Tidak Tersedia</option>
                                    <option value="rusak">Rusak</option>
                                </select>
                            </div>

                            <div class="space-y-">
                                <label class="block text-sm font-semibold text-gray-700">Jumlah</label>
                                <input type="number" name="jumlah" required min="1"
                                    class="w-full px-4 py-3 border border-gray-300 rounded  focus:outline-primary focus:border-primary transition duration-200 bg-white shadow-sm"
                                    placeholder="Jumlah buku">
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <button name="add" type="submit"
                                class="flex-1 bg-primary hover:bg-primary-600 text-white font-semibold py-3 px-6 rounded transition duration-300  shadow-lg">
                                <i class="fas fa-save mr-2"></i>Simpan Buku
                            </button>
                            <a href="index.php"
                                class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded transition duration-300 text-center">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


</body>

</html>