<?php
$path = $_SERVER['REQUEST_URI'];

function isActive($keyword)
{
    global $path;
    return strpos($path, $keyword) !== false ? 'text-primary font-bold' : '';
}
?>

<nav class="flex justify-between items-center bg-white shadow h-14 w-full p-4">
    <div class="flex items-center">
        <h1 class="font-bold text-2xl text-primary">LibriZone</h1>
        <div class="flex items-center space-x-4 ml-20 text-gray-500 font-medium">

            <a href="../dashboard/" class="<?= isActive('dashboard') ?>">Beranda</a>
            <a href="../buku/" class="<?= isActive('buku') ?>">Buku</a>
            <a href="../anggota/" class="<?= isActive('anggota') ?>">Anggota</a>
            <a href="../peminjaman/" class="<?= isActive('peminjaman') ?>">Peminjaman</a>
        </div>
    </div>

    <div class="flex items-center">
        <div class="h-10 w-10 rounded-full bg-primary"></div>
        <div class="ml-1">
            <h4 class="font-medium text-sm -mb-1">Elena Andini</h4>
            <p class="text-xs">Admin</p>
        </div>
    </div>
</nav>