<?php
include '../../middlewares/auth.php';
requireLogin();

// Handle form submission
if (isset($_POST['add_member'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);


    // Validate phone number format
    if (!empty($no_hp) && !preg_match('/^[0-9+\-\s()]+$/', $no_hp)) {
        $errors[] = "Format nomor HP tidak valid";
    }

    // Check if phone number already exists
    if (!empty($no_hp)) {
        $check_phone = "SELECT id FROM anggota WHERE no_hp = '$no_hp'";
        $check_result = mysqli_query($conn, $check_phone);
        if (mysqli_num_rows($check_result) > 0) {
            $errors[] = "Nomor HP sudah terdaftar";
        }
    }

    if (empty($errors)) {
        $insert_query = "INSERT INTO anggota (nama, alamat, no_hp) VALUES ('$nama', '$alamat', '$no_hp')";

        if (mysqli_query($conn, $insert_query)) {
            $new_member_id = mysqli_insert_id($conn);
            header("Location: index.php?success=member_added&id=" . $new_member_id);
            exit;
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibriZone</title>
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
                Kembali ke Daftar Anggota
            </a>
        </div>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Tambah Anggota Baru</h1>
            <p class="text-gray-600 mt-1">Daftarkan anggota baru perpustakaan</p>
        </div>

        <!-- Error Messages -->
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                </div>
                <ul class="list-disc list-inside">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <i class="fas fa-exclamation-circle mr-2"></i><?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>

        <!-- Add Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-user-plus mr-2 text-primary"></i>
                    Form Pendaftaran Anggota
                </h2>
            </div>

            <form method="POST" class="p-6">
                <div class="space-y-6">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" name="nama" required
                            value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>"
                            placeholder="Masukkan nama lengkap anggota"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                        <p class="text-xs text-gray-500 mt-1">Nama akan digunakan untuk identifikasi anggota</p>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea id="alamat" name="alamat" required rows="4"
                            placeholder="Masukkan alamat lengkap anggota"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"><?= isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : '' ?></textarea>
                        <p class="text-xs text-gray-500 mt-1">Alamat lengkap termasuk RT/RW, kelurahan, kecamatan</p>
                    </div>

                    <!-- Nomor HP -->
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor HP/Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="no_hp" name="no_hp" required
                            value="<?= isset($_POST['no_hp']) ? htmlspecialchars($_POST['no_hp']) : '' ?>"
                            placeholder="Contoh: 08123456789 atau 021-1234567"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                        <p class="text-xs text-gray-500 mt-1">Nomor yang dapat dihubungi untuk keperluan perpustakaan</p>
                    </div>
                </div>


                <!-- Form Actions -->
                <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="index.php"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" name="add_member"
                        class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors">
                        <i class="fas fa-user-plus mr-2"></i>Daftarkan Anggota
                    </button>
                </div>
            </form>
        </div>



</body>

</html>