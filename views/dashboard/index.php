<?php
include '../../middlewares/auth.php';
requireLogin();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibriZone</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../public/assets/css/style.css">
</head>

<body>
    <div class="container mx-auto my-12 px-4">
        <h1 class="font-bold bg-primary text-white underline text-xl p-4 rounded">
            Hello you !
        </h1>
        <h1 class="text-2xl mt-6 mb-4">Hello this is dashboard</h1>

        <button class="bg-primary text-white px-4 py-2 rounded text-sm font-medium hover:bg-primary-600 transition-colors">
            + Transaksi Baru
        </button>

        <a href="../auth/logout.php" class="ml-4 inline-block px-4 py-2 border border-red-500 text-red-500 rounded hover:bg-red-50 transition">
            Log out
        </a>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">
            <div class="bg-white shadow p-4 rounded">
                <div class="flex justify-between items-center mb-2">
                    <h6 class="text-gray-500 text-sm">Total Buku</h6>
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg- text-primary">
                        <i class="fa-solid fa-book"></i>
                    </div>
                </div>
                <p class="text-2xl font-bold">2.458</p>
            </div>

            <div class="bg-white shadow text-center p-4 rounded">
                <h5 class="text-gray-700 text-base mb-1">Buku Dipinjam</h5>
                <p class="text-3xl font-bold text-gray-900">80</p>
            </div>

            <div class="bg-white shadow text-center p-4 rounded">
                <h5 class="text-gray-700 text-base mb-1">Total Anggota</h5>
                <p class="text-xl font-semibold text-gray-900">35</p>
            </div>

            <div class="bg-white shadow text-center p-4 rounded">
                <h5 class="text-gray-700 text-base mb-1">Peminjaman Hari ini</h5>
                <p class="text-xl font-semibold text-gray-900">4</p>
            </div>
        </div>
    </div>


</body>

</html>