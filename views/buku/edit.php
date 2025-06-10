<?php
include '../../middlewares/auth.php';
requireLogin();
$id = $_GET['id'];

$query = "SELECT * FROM `buku` WHERE `id` = '$id'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $book = $result->fetch_assoc();
} else {
    die("Book not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $id_kategori = $_POST['id_kategori'];
    $status = $_POST['status'];

    $query = "UPDATE buku 
                SET judul = '$judul', 
                penulis = '$penulis', 
                penerbit = '$penerbit', 
                tahun_terbit = '$tahun_terbit', 
                id_kategori = '$id_kategori', 
                status = '$status' 
                WHERE id = '$id'";

    $result = mysqli_query($conn, $query);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
</head>

<body>
    <h1>Edit Book</h1>
    <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($book['id']); ?>">

        <label for="judul">Judul:</label>
        <input type="text" name="judul" id="judul" value="<?php echo htmlspecialchars($book['judul']); ?>" required>

        <label for="penulis">Penulis:</label>
        <input type="text" name="penulis" id="penulis" value="<?php echo htmlspecialchars($book['penulis']); ?>" required>

        <label for="penerbit">Penerbit:</label>
        <input type="text" name="penerbit" id="penerbit" value="<?php echo htmlspecialchars($book['penerbit']); ?>" required>

        <label for="tahun_terbit">Tahun Terbit:</label>
        <input type="number" name="tahun_terbit" id="tahun_terbit" value="<?php echo htmlspecialchars($book['tahun_terbit']); ?>" required>

        <label for="id_kategori">Kategori:</label>
        <input type="number" name="id_kategori" id="id_kategori" value="<?php echo htmlspecialchars($book['id_kategori']); ?>" required>

        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="1" <?php echo $book['status'] == '1' ? 'selected' : ''; ?>>Tersedia</option>
            <option value="0" <?php echo $book['status'] == '0' ? 'selected' : ''; ?>>Tidak Tersedia</option>
        </select>

        <button type="submit">Update</button>
    </form>
</body>

</html>