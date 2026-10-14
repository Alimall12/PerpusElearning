# 📚 PerpusElearning - Sistem Informasi & Perpustakaan Digital

Aplikasi perpustakaan digital berbasis web menggunakan Laravel, Tailwind CSS, dan Alpine.js. Dibangun untuk kebutuhan tugas e-learning pemrograman web selama PKL.

---

## 🌟 Fitur Utama

### 1. Pengguna & Anggota (Siswa / Pembaca)
- **Autentikasi & Registrasi**: Login, Register akun, lengkapi profil keanggotaan.
- **Katalog Buku Interaktif**:
  - Filter checklist multi-select model accordion (Kategori/Genre bertingkat, Pengarang, Penerbit).
  - Pencarian instan (Judul & Pengarang).
  - Slider cover depan dan cover belakang buku (Alpine.js).
- **Review & Rating**: Ulasan komentar dan rating bintang 1–5 pada tiap buku.
- **Peminjaman Mandiri**: Ajukan pinjam buku secara langsung dengan validasi stok otomatis.
- **Baca Online (E-Reader)**: Baca buku digital langsung di browser untuk buku yang sedang dipinjam.
- **Wishlist Buku**: Simpan daftar buku favorit / dibaca nanti.
- **Pengembalian Mandiri**: Kembalikan buku pinjaman melalui menu peminjaman.

### 2. Admin Perpustakaan
- **Dashboard Statistik**: Ringkasan stok buku, total anggota, dan peminjaman aktif.
- **Kelola Buku (CRUD)**:
  - Input kode buku otomatis/manual, judul, pengarang, penerbit, tahun, stok.
  - Upload file e-book (PDF) dan cover depan/belakang buku.
  - Multi-level genre selector.
- **Kelola Anggota (CRUD)**: Manajemen data siswa/anggota perpustakaan.
- **Kelola Peminjaman**: Pantau status peminjaman, batas tanggal kembali, dan denda.

---

## 🛠️ Kebutuhan Sistem

- PHP >= 8.2
- Composer >= 2.x
- Node.js & NPM (versi LTS)
- Database: MySQL (Laragon / XAMPP) atau SQLite

---

## 🚀 Panduan Instalasi Lokal

### 1. Clone Repository
```bash
git clone https://github.com/Alimall12/PerpusElearning.git
cd PerpusElearning
```

### 2. Install Dependency PHP & Node.js
```bash
composer install
npm install
```

### 3. Setup File Environment
Salin template konfigurasi `.env`:
```bash
copy .env.example .env
```
Generate application key:
```bash
php artisan key:generate
```

### 4. Konfigurasi Database di `.env`
Buka file `.env` dan sesuaikan koneksi database Anda:

**Opsi A (MySQL - Laragon / XAMPP):**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_perpus
DB_USERNAME=root
DB_PASSWORD=
```
*(Pastikan database `db_perpus` sudah dibuat di phpMyAdmin / HeidiSQL).*

**Tambahkan password default admin di `.env`:**
```env
ADMIN_DEFAULT_PASSWORD=admin123
```

### 5. Jalankan Migrasi & Seeder
```bash
php artisan migrate --seed
```

### 6. Hubungkan Storage Upload Gambar & E-Book
**Wajib** dijalankan agar cover buku dan file PDF muncul di browser:
```bash
php artisan storage:link
```

### 7. Compile Asset Frontend
```bash
npm run build
# Atau untuk mode development:
npm run dev
```

### 8. Jalankan Server Lokal
```bash
php artisan serve
```
Aplikasi dapat diakses di: **`http://127.0.0.1:8000`**

---

## 🔑 Akun Bawaan (Default Credentials)

| Role | Email | Password | Keterangan |
|------|-------|----------|------------|
| **Admin** | `admin@perpustakaan.com` | `admin123` | Akses dashboard, kelola buku, anggota & transaksi |
| **User Demo** | `test@example.com` | `password` | Akun anggota demo untuk uji coba peminjaman |

---

## 📁 Struktur Folder Penting

```
perpustakaan/
├── app/
│   ├── Http/Controllers/
│   │   ├── BukuController.php          # CRUD Buku & e-reader PDF
│   │   ├── KatalogController.php       # Katalog filter checklist & pencarian
│   │   ├── PeminjamanController.php    # Transaksi pinjam & kembali
│   │   ├── ReviewController.php        # Rating & ulasan buku
│   │   └── WishlistController.php      # Fitur simpan wishlist
│   └── Models/
├── config/
│   └── genres.php                      # Mapping kategori & kode klasifikasi genre
├── database/
│   ├── migrations/                     # Skema tabel database
│   └── seeders/                        # Data awal admin & akun demo
├── resources/views/
│   ├── buku/                           # View CRUD buku (Admin)
│   ├── katalog/                        # Tampilan katalog & detail buku
│   ├── peminjaman/                     # Riwayat & status peminjaman
│   └── wishlist/                       # Daftar simpan buku
└── routes/
    └── web.php                         # Definisi semua rute web
```


## Troubleshooting

**404 Not Found saat akses /buku**
- Pastikan sudah login sebagai admin
- Clear cache: `php artisan route:clear && php artisan cache:clear`

**Error koneksi database**
- Pastikan MySQL berjalan
- Cek konfigurasi `.env` (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
- Pastikan database `db_perpus` sudah dibuat

**Assets tidak muncul**
- Jalankan: `npm run build`
- Atau development mode: `npm run dev`

## Pengembangan Selanjutnya

Fitur yang bisa ditambahkan:
- Tabel Anggota (nis, nama, kelas)
- Tabel Peminjaman (relasi dengan buku & anggota)
- Transaksi peminjaman & pengembalian
- Laporan & statistik
- Export data (PDF, Excel)

## Lisensi

Project ini dibuat untuk keperluan pembelajaran.

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects.

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

