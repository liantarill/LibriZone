<?php
$path = $_SERVER['REQUEST_URI'];

function isActive($keyword)
{
    global $path;
    return strpos($path, $keyword) !== false ? 'text-primary font-bold' : '';
}
?>

<nav class="flex justify-between fixed left-0 top-0 items-center bg-white shadow h-14 w-full p-4">
    <div class="flex items-center">
        <h1 class="font-bold text-2xl text-primary">LibriZone</h1>
        <div class="flex items-center space-x-4 ml-20 text-gray-500 font-medium">

            <a href="../dashboard/" class="<?= isActive('dashboard') ?> px-3">Beranda</a>
            <a href="../buku/" class="<?= isActive('buku') ?> px-3">Buku</a>
            <a href="../anggota/" class="<?= isActive('anggota') ?> px-3">Anggota</a>
            <a href="../peminjaman/" class="<?= isActive('peminjaman') ?> px-3">Peminjaman</a>
        </div>
    </div>

    <div class="relative group inline-block">
        <!-- Profil: Avatar + Nama -->
        <div class="flex items-center space-x-2 cursor-pointer">
            <div class="h-10 w-10 rounded-full bg-primary"></div>
            <div>
                <h4 class="font-medium text-sm -mb-1">Elena Andini</h4>
                <p class="text-xs">Admin</p>
            </div>
        </div>

        <!-- Dropdown Logout -->
        <div
            class="absolute right-0 mt-2 w-32 bg-white border-2 border-white hover:border-red-500 hover:border-2   rounded shadow-md
           opacity-0 invisible group-hover:opacity-100 group-hover:visible
           transition-all duration-300 z-50">
            <a href="../auth/logout.php"
                class="block px-4 py-2 text-center text-gray-700 rounded hover:text-red-500 font-medium text-base">
                Logout
            </a>
        </div>
    </div>

</nav>