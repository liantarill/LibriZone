<?php
include '../../middlewares/auth.php';
requireLogin();



$member_id = mysqli_real_escape_string($conn, $_GET['id']);

// Get member information
$member_query = "SELECT * FROM anggota WHERE id = '$member_id'";
$member_result = mysqli_query($conn, $member_query);

if (mysqli_num_rows($member_result) == 0) {
    header("Location: index.php?error=member_not_found");
    exit;
}

$member = mysqli_fetch_assoc($member_result);

// Get borrowing history with book details
$history_query = "SELECT p.*, b.judul as judul_buku, b.penulis, b.penerbit
                  FROM peminjaman p 
                  LEFT JOIN buku b ON p.id_buku = b.id 
                  WHERE p.id_anggota = '$member_id' 
                  ORDER BY p.tanggal_pinjam DESC";

$history_result = mysqli_query($conn, $history_query);

if (!$history_result) {
    die("Error in query: " . mysqli_error($conn));
}

// Get statistics
$stats_query = "SELECT 
                    COUNT(*) as total_pinjam,
                    SUM(CASE WHEN status_pengembalian = 'sudah' THEN 1 ELSE 0 END) as total_kembali,
                    SUM(CASE WHEN status_pengembalian = 'belum' THEN 1 ELSE 0 END) as sedang_dipinjam
                FROM peminjaman 
                WHERE id_anggota = '$member_id'";

$stats_result = mysqli_query($conn, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);

// Function to calculate due date (7 days from borrow date)
function calculateDueDate($tanggal_pinjam)
{
    $date = new DateTime($tanggal_pinjam);
    $date->add(new DateInterval('P7D'));
    return $date->format('Y-m-d');
}

// Function to check if overdue
function isOverdue($tanggal_pinjam, $status_pengembalian)
{
    if ($status_pengembalian !== 'dipinjam') return false;

    $due_date = calculateDueDate($tanggal_pinjam);
    $today = date('Y-m-d');
    return $today > $due_date;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Anggota - <?= htmlspecialchars($member['nama']) ?></title>
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

        <!-- Member Info Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center text-white text-2xl">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($member['nama']) ?></h1>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">ID Anggota:</span>
                                <span class="font-semibold text-gray-800 ml-2">#<?= htmlspecialchars($member['id']) ?></span>
                            </div>
                            <div>
                                <span class="text-gray-600">No. HP:</span>
                                <span class="font-semibold text-gray-800 ml-2"><?= htmlspecialchars($member['no_hp']) ?></span>
                            </div>
                            <div>
                                <span class="text-gray-600">Alamat:</span>
                                <span class="font-semibold text-gray-800 ml-2"><?= htmlspecialchars($member['alamat']) ?></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <i class="fas fa-book"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Pinjam</p>
                        <p class="text-xl font-bold text-gray-900"><?= $stats['total_pinjam'] ?></p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Dikembalikan</p>
                        <p class="text-xl font-bold text-gray-900"><?= $stats['total_kembali'] ?></p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Sedang Dipinjam</p>
                        <p class="text-xl font-bold text-gray-900"><?= $stats['sedang_dipinjam'] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Borrowing History Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-history mr-2 text-primary"></i>
                    Riwayat Peminjaman
                </h2>
            </div>

            <div class="overflow-x-auto">
                <?php if (mysqli_num_rows($history_result) == 0): ?>
                    <div class="text-center py-12">
                        <i class="fas fa-book text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Riwayat Peminjaman</h3>
                        <p class="text-gray-500">Anggota ini belum pernah meminjam buku.</p>
                    </div>
                <?php else: ?>
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Buku</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">penulis</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batas Kembali</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Kembali</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            $no = 1;
                            while ($history = mysqli_fetch_assoc($history_result)):
                                $due_date = calculateDueDate($history['tanggal_pinjam']);
                                $is_overdue = isOverdue($history['tanggal_pinjam'], $history['status_pengembalian']);
                            ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?= $no++ ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <div class="font-medium"><?= htmlspecialchars($history['judul_buku'] ?: 'Judul tidak tersedia') ?></div>
                                        <div class="text-xs text-gray-500">ID Buku: <?= htmlspecialchars($history['id_buku']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <?= htmlspecialchars($history['penulis'] ?: '-') ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?= date('d/m/Y', strtotime($history['tanggal_pinjam'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="<?= $is_overdue ? 'text-red-600 font-semibold' : '' ?>">
                                            <?= date('d/m/Y', strtotime($due_date)) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?= $history['tanggal_kembali'] ? date('d/m/Y', strtotime($history['tanggal_kembali'])) : '-' ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if ($history['status_pengembalian'] === 'belum'): ?>
                                            <?php if ($is_overdue): ?>
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>Terlambat
                                                </span>
                                            <?php else: ?>
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    <i class="fas fa-clock mr-1"></i>Dipinjam
                                                </span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>Dikembalikan
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <?php if ($history['status_pengembalian'] === 'belum'): ?>
                                            <a href="return_book.php?id=<?= $history['id'] ?>"
                                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs transition-colors"
                                                onclick="return confirm('Konfirmasi pengembalian buku ini?')">
                                                <i class="fas fa-undo mr-1"></i>Kembalikan
                                            </a>
                                        <?php else: ?>
                                            <span class="text-gray-400 text-xs">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>


</body>

</html>