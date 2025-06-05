# LibriZone

**Manajemen Perpustakaan Sederhana**
Proyek ini merupakan aplikasi manajemen perpustakaan berbasis web yang dibuat menggunakan **PHP Native**, **MySQL**, dan **Tailwind CSS (CLI)**.

## Repository

[GitHub - LibriZone](https://github.com/liantarill/LibriZone.git)

## Teknologi yang Digunakan

- **PHP Native** – Backend logic
- **MySQL** – Database
- **Tailwind CSS (CLI)** – Styling UI
- **Node.js + NPM** – Untuk menjalankan Tailwind CLI

## Fitur Utama

- Manajemen data buku
- Peminjaman dan pengembalian buku
- Manajemen anggota
- Dashboard admin

## Struktur Database

**Nama database:** `librizone`
**File impor:** `sql/table_librizone.sql`

### Cara Mengimpor:

1. Buka phpMyAdmin.
2. Buat database baru dengan nama `librizone`.
3. Impor file `sql/table_librizone.sql` yang ada di dalam repositori.

## Cara Menjalankan Proyek

1. Clone repository:

   ```bash
   git clone https://github.com/liantarill/LibriZone.git
   ```

2. Masuk ke folder proyek:

   ```bash
   cd LibriZone
   ```

3. Install dependensi Tailwind CSS via NPM:

   ```bash
   npm install
   ```

4. Jalankan proyek:

   - Pastikan server lokal kamu (XAMPP/Laragon/dll.) sudah berjalan.

   - Jalankan proyek dengan perintah berikut untuk memantau perubahan Tailwind CSS dan BrowserSync secara bersamaan:

   ```bash
   npm run start
   ```

## Catatan

- Pastikan PHP dan MySQL sudah aktif.
- Tailwind CLI membutuhkan Node.js & NPM terinstal di sistem Anda.
