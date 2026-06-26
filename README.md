# 🚰 Sistem Informasi Pengaduan Pelanggan PDAM Berbasis Web

Sistem Informasi Pengaduan Pelanggan PDAM Berbasis Web merupakan aplikasi yang dikembangkan untuk membantu proses pengelolaan pengaduan pelanggan secara digital. Aplikasi ini memungkinkan pelanggan mengirimkan pengaduan secara online, admin melakukan verifikasi dan penugasan petugas, serta petugas memperbarui status penanganan pengaduan secara real-time.

## 📌 Fitur Utama

* Login dan Registrasi Multi Role (Admin, Petugas, Pelanggan)
* Verifikasi Akun Pelanggan
* Pengajuan Pengaduan dengan Upload Foto
* Tracking Status Pengaduan
* Verifikasi Pengaduan oleh Admin
* Penugasan Petugas Lapangan
* Update Status Penanganan
* Upload Dokumentasi Sebelum & Sesudah Perbaikan
* Dashboard Admin
* Dashboard Petugas
* Dashboard Pelanggan
* Manajemen Data Pelanggan
* Manajemen Data Petugas
* Riwayat Pengaduan
* Notifikasi Email dan WhatsApp
* Laporan Pengaduan (PDF & Excel)
* Statistik Dashboard

---

## 🛠️ Teknologi

* PHP 8.x
* Laravel 12
* MySQL
* Bootstrap 5
* Blade Template Engine
* JavaScript
* HTML5
* CSS3
* Font Awesome

---

## 👥 Hak Akses Pengguna

### Admin

* Login
* Verifikasi pelanggan
* Mengelola data pelanggan
* Mengelola data petugas
* Mengelola pengaduan
* Menugaskan petugas
* Melihat laporan
* Mengelola dashboard

### Petugas

* Login
* Melihat daftar tugas
* Memproses pengaduan
* Mengubah status penanganan
* Mengunggah foto penyelesaian
* Melihat riwayat tugas

### Pelanggan

* Registrasi
* Login
* Mengajukan pengaduan
* Upload foto pengaduan
* Melihat status pengaduan
* Melihat riwayat pengaduan
* Mengelola profil

---

## 📂 Struktur Project

```text
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
artisan
composer.json
```

---

## ⚙️ Instalasi

Clone repository

```bash
git clone https://github.com/Amaliya-code/sistem_layanan_pengaduan_PDAM.git
```

Masuk ke folder project

```bash
cd sistem_layanan_pengaduan_PDAM
```

Install dependency

```bash
composer install
```

Copy file environment

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Atur konfigurasi database pada file `.env`

Jalankan migrasi dan seeder

```bash
php artisan migrate --seed
```

Buat symbolic link storage

```bash
php artisan storage:link
```

Jalankan aplikasi

```bash
php artisan serve
```

Akses melalui browser

```
http://127.0.0.1:8000
```

---

## 🎯 Tujuan Sistem

* Mempermudah pelanggan dalam menyampaikan pengaduan.
* Mempercepat proses verifikasi dan penanganan pengaduan.
* Memudahkan admin dalam mengelola data pelanggan dan petugas.
* Menyediakan informasi status pengaduan secara real-time.
* Meningkatkan kualitas pelayanan PDAM melalui sistem yang terintegrasi.

---

## 📖 Pengembang

**Amaliya**
Program Studi Sistem Informasi

---

## 📄 Lisensi

Project ini dikembangkan untuk keperluan penelitian dan penyusunan skripsi Program Studi Sistem Informasi.
