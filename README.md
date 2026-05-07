# BukuLoan - Sistem Informasi Peminjaman Buku 📚

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

**BukuLoan** adalah aplikasi manajemen perpustakaan modern yang dirancang khusus untuk **Latihan Uji Kompetensi Keahlian (UKK) Kelas XII Jurusan Pengembangan Perangkat Lunak dan Gim (PPLG)**. Proyek ini mendemonstrasikan implementasi CRUD, sistem autentikasi, manajemen relasi database, dan antarmuka pengguna yang responsif.

---

## ✨ Fitur Utama

### 👨‍💼 Panel Admin
- **Dashboard Statistik**: Pantau total buku, anggota, dan status peminjaman secara real-time.
- **Manajemen Buku**: CRUD (Create, Read, Update, Delete) data koleksi buku perpustakaan.
- **Manajemen Anggota**: Kelola data pengguna/siswa yang terdaftar.
- **Manajemen Transaksi**: Proses peminjaman dan pengembalian buku dengan validasi stok otomatis.

### 👤 Panel Anggota/Siswa
- **Katalog Buku**: Menelusuri daftar buku yang tersedia untuk dipinjam.
- **Riwayat Peminjaman**: Melihat status buku yang sedang dipinjam atau sudah dikembalikan.
- **Sistem Peminjaman Mandiri**: Mengajukan peminjaman buku secara digital.

---

## 🛠️ Teknologi yang Digunakan

| Komponen | Teknologi |
| --- | --- |
| **Framework Backend** | [Laravel 12](https://laravel.com) |
| **Frontend Framework** | [Tailwind CSS](https://tailwindcss.com) & [Alpine.js](https://alpinejs.dev) |
| **Authentication** | [Laravel Breeze](https://laravel.com/docs/breeze) |
| **Database** | MySQL / MariaDB |
| **Build Tool** | Vite |

---

## 🚀 Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di lingkungan lokal Anda:

### 1. Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/XAMPP

### 2. Kloning Project
```bash
git clone https://github.com/username/buku-loan.git
cd buku-loan
```

### 3. Instalasi Dependensi
```bash
composer install
npm install
```

### 4. Konfigurasi Environment
Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Setup Database
Pastikan database dengan nama `peminjaman_buku` sudah dibuat di MySQL, lalu jalankan migrasi:
```bash
php artisan migrate
```
Atau jika Anda ingin menggunakan file SQL yang disediakan:
1. Impor `database_schema.sql` ke dalam database Anda.

### 6. Jalankan Aplikasi
Jalankan server pengembangan Laravel dan Vite secara bersamaan:
```bash
# Terminal 1 (Laravel)
php artisan serve

# Terminal 2 (Vite)
npm run dev
```

---

## 🔐 Akun Akses Default

Gunakan kredensial berikut untuk masuk ke sistem pertama kali:

**Admin:**
- Email: `admin@admin.com`
- Password: `password` (Silakan buat melalui register atau seeder jika perlu)

**User:**
- Email: `user@user.com`
- Password: `password` (Silakan buat melalui register atau seeder jika perlu)

---

## 📄 Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---
*Dibuat untuk tujuan edukasi dan persiapan Uji Kompetensi Keahlian (UKK).*
