## Tutorial Clone Proyek

### 1. **Clone Repository dari GitHub**

Buka terminal atau CMD, lalu jalankan:

```bash
git clone https://github.com/liantarill/LibriZone.git
cd LibriZone
```

> Pastikan kamu sudah menginstall Git. Kalau belum, download dari [git-scm.com](https://git-scm.com/).

---

### 2. **Pasang Dependensi Tailwind CSS**

Jalankan perintah berikut untuk menginstal semua dependensi:

```bash
npm install
```

---

> Pastikan kamu sudah menginstall [Node.js](https://nodejs.org/en/) terlebih dahulu.

### 3. **Jalankan Tailwind agar CSS Terupdate Otomatis**

Agar Tailwind meng-compile otomatis setiap kamu menyimpan file:

```bash
npm run dev
```

---

### 4. **Buat Database `librizone`**

1. Buka **phpMyAdmin** atau tools database lainnya.
2. Buat database baru dengan nama: `librizone`
3. Import struktur dan data tabel dari file berikut:

   ```
   sql/table_librizone.sql
   ```

   > Di phpMyAdmin: Pilih database `librizone` → tab **Import** → pilih file `table_librizone.sql` → klik **Go**.

---

### 5. **Akses Proyek via Browser**

Buka browser dan akses:

```
http://localhost/librizone/views/dashboard/index.php
```

> ✅ _Pastikan kamu sudah menjalankan **XAMPP / Laragon / Apache** dan meletakkan folder `LibriZone` di dalam direktori `htdocs` (untuk XAMPP) atau `www` (untuk Laragon)._
