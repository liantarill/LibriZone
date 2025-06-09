<?php
include '../../middlewares/auth.php';
include 'detail.php';
include 'edit.php';

$query = "SELECT * FROM anggota";
$result = mysqli_query($conn, $query);


function edit($id, $nama, $alamat, $no_hp)
{
    $edit = "UPDATE anggota SET nama = '$nama', alamat ='$alamat', no_hp = '$no_hp' WHERE id='$id'";
}

if (isset($_POST['update'])) {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    $id = $_POST['id'];
    $nama = $_POST['editNama'];
    $alamat = $_POST['editAlamat'];
    $no_hp = $_POST['editNoHp'];

    $query = "UPDATE anggota SET 
                nama = '$nama', 
                alamat = '$alamat', 
                no_hp = '$no_hp' 
              WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        // Hindari echo langsung, ganti dengan redirect:
        header("Location: index.php?status=updated");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibriZone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../public/assets/css/style.css">
</head>

<body>
    <?php include '../layouts/navbar.php' ?>

    <div class="container mx-auto my-16 px-4">
        <h1 class="text-2xl mt-6 mb-4">Hello this is all memberrr</h1>
        <button class="bg-primary text-white px-4 py-2 rounded text-sm font-medium hover:bg-primary-600 transition-colors">
            + Tambah Anggota
        </button>

        <a href="../auth/logout.php" class="ml-4 inline-block px-4 py-2 border border-red-500 text-red-500 rounded hover:bg-red-50 transition">
            Log out
        </a>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'updated'): ?>
            <div class="bg-green-100 mt-2 text-green-800 p-4 rounded">Data berhasil diupdate.</div>
        <?php endif; ?>


        <!-- Transaksi Terbaru -->
        <div class="mt-10  rounded shadow bg-white p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-500">List buku</h3>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" placeholder="Cari..."
                            class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="py-7">
                <table class="w-full text-left font-medium text-xs text-gray-500 ">
                    <thead class="bg-gray-100 ">
                        <th class="px-2 py-2">ID</th>
                        <th class="px-2 py-2">NAMA</th>
                        <th class="px-2 py-2">AKSI</th>

                    </thead>
                    <tbody>
                        <?php
                        while ($user = mysqli_fetch_assoc($result)) {
                            $popupId = "popupDelete_" . $user['id'];

                            echo "<tr class='hover:bg-gray-50 border-b'>";
                            echo "<td class='px-2 py-2'>" . htmlspecialchars($user['id']) . "</td>";
                            echo "<td class='px-2 py-2'>" . htmlspecialchars($user['nama']) . "</td>";

                            echo "<td class='px-2  py-2'>";
                            echo '<div class="flex gap-2">
        <button onclick="openDetail(' .
                                "'" . $user['id'] . "', " .
                                "'" . $user['nama'] . "', " .
                                "'" . $user['alamat'] . "', " .
                                "'" . $user['no_hp'] . "'" .
                                ')" class="bg-blue-400 font-semibold text-white py-2 px-4 rounded shadow">
        <i class="fa-solid fa-eye"></i> Detail</button>

        <button onclick="openEdit(' .
                                "'" . $user['id'] . "', " .
                                "'" . $user['nama'] . "', " .
                                "'" . $user['alamat'] . "', " .
                                "'" . $user['no_hp'] . "'" .
                                ')" class="bg-orange-400 font-semibold text-white py-2 px-4 rounded shadow">
                    <i class="fa-solid fa-pen-to-square"></i> Edit</button>

                    <button popovertarget="' . $popupId . '" class="bg-red-400 font-semibold text-white py-2 px-4 rounded shadow">
                    <i class="fa-solid fa-trash"></i> Delete</button>
                    </div>';
                            echo "</td>";
                            echo "</tr>";

                            echo '<div class="bg-yellow-200 rounded-md p-4 shadow text-center" id="' . $popupId . '" popover>
                                    <span class="">Apakah anda yakin untuk menghapus: ' . htmlspecialchars($user['nama']) . '?</span>
                                    <div class="flex justify-center mt-2 gap-4">
                                        <a href="" popovertargetaction="hide" class="bg-green-500 px-5 text-white font-medium rounded">Batal</a>
                                        <a href="delete.php?id=' . urlencode($user['id']) . '" class="bg-red-400 px-5 text-white font-medium rounded">Hapus</a>
                                    </div>
                                </div>';
                        }
                        ?>
                    </tbody>


                </table>

            </div>
        </div>


    </div>
    <script>
        function openDetail(id, nama, alamat, no_hp) {
            document.getElementById('id').innerHTML = id;
            document.getElementById('nama').innerHTML = nama;
            document.getElementById('alamat').innerHTML = alamat;
            document.getElementById('no_hp').innerHTML = no_hp;
            document.getElementById('detailModal').classList.remove('hidden');
        }

        function openEdit(id, nama, alamat, no_hp) {
            document.getElementById('editId').value = id;
            document.getElementById('editNama').value = nama;
            document.getElementById('editAlamat').value = alamat;
            document.getElementById('editNoHp').value = no_hp;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal(e) {
            document.getElementById(e).classList.add('hidden')
        }
        const detailModal = document.getElementById('detailModal');
        const editModal = document.getElementById('editModal');

        detailModal.addEventListener('click', function(e) {
            if (e.target === detailModal) {
                detailModal.classList.add('hidden');
            }
        });
        editModal.addEventListener('click', function(e) {
            if (e.target === editModal) {
                editModal.classList.add('hidden');
            }
        });
    </script>
</body>

</html>