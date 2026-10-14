# Sistem Perpustakaan

Aplikasi manajemen perpustakaan menggunakan Laravel 13 dengan fitur CRUD buku dan autentikasi admin.

## Fitur

- ✅ CRUD Data Buku (Create, Read, Update, Delete)
- ✅ Validasi Form Input
- ✅ Konfirmasi Hapus Data
- ✅ Sistem Login Admin (Laravel Breeze)
- ✅ Dashboard Admin

## Teknologi

- Laravel 13.17
- PHP 8.3
- MySQL 8.4
- Laravel Breeze (Authentication)
- Tailwind CSS & Bootstrap 5

## Struktur Database

**Database:** `db_perpus`

**Tabel buku:**
- id (bigint, auto increment, primary key)
- kode_buku (varchar 20, unique)
- judul (varchar 150)
- pengarang (varchar 100)
- penerbit (varchar 100)
- tahun_terbit (year)
- stok (int)
- created_at, updated_at (timestamp)

## Instalasi

### 1. Clone / Download Project

```bash
cd d:/laragon/www
# Atau lokasi project Anda
```

### 2. Install Dependencies

```bash
cd perpustakaan
composer install
npm install
```

### 3. Konfigurasi Environment

Copy `.env.example` menjadi `.env`:

```bash
copy .env.example .env
```

Edit `.env` sesuai database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_perpus
DB_USERNAME=root
DB_PASSWORD=
```

Generate application key:

```bash
php artisan key:generate
```

### 4. Jalankan Migration

```bash
php artisan migrate
```

### 5. Buat Akun Admin

```bash
php artisan db:seed --class=AdminSeeder
```

**Kredensial Admin:**
- Email: `admin@perpustakaan.com`
- Password: `admin123`

### 6. Build Assets

```bash
npm run build
```

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi berjalan di: **http://127.0.0.1:8000**

## Cara Menggunakan

### Login Admin

1. Buka browser: http://127.0.0.1:8000/login
2. Login dengan kredensial:
   - Email: `admin@perpustakaan.com`
   - Password: `admin123`
3. Setelah login, klik tombol **"Kelola Data Buku"** di dashboard

### Menu Kelola Buku

URL: http://127.0.0.1:8000/buku

**Operasi:**
- **Tambah Buku:** Klik tombol "+ Tambah Buku"
- **Edit Buku:** Klik tombol "Edit" pada baris data
- **Hapus Buku:** Klik tombol "Hapus" (akan muncul konfirmasi)

**Validasi Form:**
- Kode Buku: required, unique
- Judul: required
- Pengarang: required
- Penerbit: required
- Tahun Terbit: required, numeric
- Stok: required, numeric

### Logout

Klik menu profile di kanan atas → Log Out

## Struktur File Penting

```
perpustakaan/
├── app/
│   ├── Http/Controllers/
│   │   └── BukuController.php          # Controller CRUD Buku
│   └── Models/
│       └── Buku.php                     # Model Buku
├── database/
│   ├── migrations/
│   │   └── xxxx_create_buku_table.php   # Migration tabel buku
│   └── seeders/
│       └── AdminSeeder.php              # Seeder admin
├── resources/views/
│   ├── buku/
│   │   ├── index.blade.php              # Daftar buku
│   │   ├── create.blade.php             # Form tambah buku
│   │   └── edit.blade.php               # Form edit buku
│   └── dashboard.blade.php              # Dashboard admin
└── routes/
    └── web.php                          # Route definitions
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

