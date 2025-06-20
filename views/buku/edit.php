<?php
include '../../middlewares/auth.php';
requireLogin();

// Check if ID is provided
if (!isset($_GET['id'])) {
    header("Location: index.php?error=no_id");
    exit;
}

$book_id = mysqli_real_escape_string($conn, $_GET['id']);

// Get book information
$book_query = "SELECT * FROM buku WHERE id = '$book_id'";
$book_result = mysqli_query($conn, $book_query);

if (mysqli_num_rows($book_result) == 0) {
    header("Location: index.php?error=book_not_found");
    exit;
}

$book = mysqli_fetch_assoc($book_result);

// Get categories for dropdown
$category_query = "SELECT * FROM kategori ORDER BY nama_kategori";
$category_result = mysqli_query($conn, $category_query);

// Handle form submission
if (isset($_POST['update_book'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun_terbit = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);
    $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Validation

    $update_query = "UPDATE buku SET 
                            judul = '$judul',
                            penulis = '$penulis',
                            penerbit = '$penerbit',
                            tahun_terbit = '$tahun_terbit',
                            id_kategori = '$id_kategori',
                            jumlah = '$jumlah',
                            status = '$status'
                         WHERE id = '$book_id'";

    if (mysqli_query($conn, $update_query)) {
        header("Location: index.php?success=book_updated");
        exit;
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - LibriZone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../public/assets/css/style.css">
</head>

<body class="bg-gray-50">
    <?php include '../layouts/navbar.php' ?>

    <div class="container mx-auto my-16 px-4">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="index.php" class="inline-flex items-center text-primary hover:text-primary-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Buku
            </a>
        </div>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Edit Buku</h1>
            <p class="text-gray-600 mt-1">Perbarui informasi buku</p>
        </div>


        <!-- Edit Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-edit mr-2 text-primary"></i>
                    Form Edit Buku
                </h2>
            </div>

            <form method="POST" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Judul Buku -->
                    <div class="md:col-span-2">
                        <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Buku <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="judul" name="judul" required
                            value="<?= htmlspecialchars($book['judul']) ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>

                    <!-- Penulis -->
                    <div>
                        <label for="penulis" class="block text-sm font-medium text-gray-700 mb-2">
                            Penulis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="penulis" name="penulis" required
                            value="<?= htmlspecialchars($book['penulis']) ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>

                    <!-- Penerbit -->
                    <div>
                        <label for="penerbit" class="block text-sm font-medium text-gray-700 mb-2">
                            Penerbit <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="penerbit" name="penerbit" required
                            value="<?= htmlspecialchars($book['penerbit']) ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>

                    <!-- Tahun Terbit -->
                    <div>
                        <label for="tahun_terbit" class="block text-sm font-medium text-gray-700 mb-2">
                            Tahun Terbit <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="tahun_terbit" name="tahun_terbit" required
                            value="<?= htmlspecialchars($book['tahun_terbit']) ?>"
                            min="1900" max="<?= date('Y') ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="id_kategori" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori
                        </label>
                        <select id="id_kategori" name="id_kategori"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                            <option value="">Pilih Kategori</option>
                            <?php while ($category = mysqli_fetch_assoc($category_result)): ?>
                                <option value="<?= $category['id'] ?>"
                                    <?= $book['id_kategori'] == $category['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['nama_kategori']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah Buku <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="jumlah" name="jumlah" required
                            value="<?= htmlspecialchars($book['jumlah']) ?>"
                            min="0"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status Buku
                        </label>
                        <select id="status" name="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                            <option value="tersedia" <?= $book['status'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                            <option value="dipinjam" <?= $book['status'] == 'dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                        </select>
                    </div>
                </div>

                <!-- Current Book Info -->
                <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Informasi Saat Ini:</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">ID Buku:</span>
                            <div class="font-medium">#<?= htmlspecialchars($book['id']) ?></div>
                        </div>
                        <div>
                            <span class="text-gray-600">Status Saat Ini:</span>
                            <div class="font-medium capitalize"><?= htmlspecialchars($book['status']) ?></div>
                        </div>
                        <div>
                            <span class="text-gray-600">Jumlah Saat Ini:</span>
                            <div class="font-medium"><?= htmlspecialchars($book['jumlah']) ?> buku</div>
                        </div>
                        <div>
                            <span class="text-gray-600">Tahun Terbit:</span>
                            <div class="font-medium"><?= htmlspecialchars($book['tahun_terbit']) ?></div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="index.php"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" name="update_book"
                        class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Additional Info -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                <div class="text-sm text-blue-800">
                    <p class="font-medium mb-1">Catatan:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Field yang bertanda (*) wajib diisi</li>
                        <li>Pastikan jumlah buku sesuai dengan stok fisik</li>
                        <li>Status buku akan mempengaruhi ketersediaan untuk peminjaman</li>
                        <li>Tahun terbit harus antara 1900 hingga <?= date('Y') ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>