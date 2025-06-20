CREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL 
);

CREATE TABLE anggota (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT,
    no_hp VARCHAR(20)
);

CREATE TABLE kategori (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_kategori VARCHAR(50) NOT NULL
);

CREATE TABLE buku (
    id INT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(150) NOT NULL,
    penulis VARCHAR(100),
    penerbit VARCHAR(100),
    tahun_terbit YEAR,
    id_kategori INT,
    jumlah INT NOT NULL DEFAULT 0,
    status ENUM('tersedia', 'dipinjam') DEFAULT 'tersedia',
);


CREATE TABLE peminjaman (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_anggota INT,
    id_buku INT,
    tanggal_pinjam DATE,
    tanggal_kembali DATE,
    status_pengembalian ENUM('belum', 'sudah') DEFAULT 'belum',
);


INSERT INTO `admin`(`username`, `password`) VALUES ('admin','$2y$12$FhK1.TJTeap/UnsxDgMN8.0eVD70DNvSkQiawb74X123h4v9iIHOy')