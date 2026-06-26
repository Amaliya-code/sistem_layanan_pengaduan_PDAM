# Panduan Penggunaan Sistem Informasi Pengaduan PDAM

## Akses Aplikasi
- **URL**: http://127.0.0.1:8000
- **Server**: Sedang berjalan di port 8000

## Akun Testing yang Tersedia

### 1. Admin
- **Email**: admin@pdam.local
- **Password**: admin123
- **Fitur**: Verifikasi pelanggan, kelola pengaduan, assign petugas, generate laporan

### 2. Petugas (3 akun)
- **Email**: petugas1@pdam.local, petugas2@pdam.local, petugas3@pdam.local
- **Password**: petugas123
- **Fitur**: Update status pengaduan yang ditugaskan

### 3. Pelanggan (10 akun)
- **Email**: pelanggan1@pdam.local sampai pelanggan10@pdam.local
- **Password**: customer123
- **Fitur**: Buat pengaduan, lihat tracking pengaduan
- **Status**: Semua sudah terverifikasi (siap login)

## Alur Penggunaan

### A. Untuk Pelanggan Baru (Registrasi)
1. Buka http://127.0.0.1:8000
2. Klik "Daftar" atau buka http://127.0.0.1:8000/register
3. Isi form lengkap:
   - Nama Lengkap
   - Email
   - Nomor WhatsApp
   - Nomor Meteran/ Pelanggan
   - Alamat
   - No. Telepon
   - **Foto UTP** (wajib upload)
   - Password
4. Submit form
5. Sistem akan menyimpan data dengan status "belum terverifikasi"
6. Admin akan menerima notifikasi WhatsApp tentang pendaftaran baru

### B. Untuk Admin (Verifikasi Pelanggan)
1. Login sebagai admin@pdam.local / admin123
2. Admin akan melihat notifikasi di dashboard
3. Klik "Verifikasi Pelanggan" atau buka http://127.0.0.1:8000/admin/pelanggan/belum-verifikasi
4. Lihat daftar pelanggan yang menunggu verifikasi
5. Klik tombol "Verifikasi" pada pelanggan yang akan diverifikasi
6. Pilih "Setujui" atau "Tolak"
7. Tambahkan catatan (opsional)
8. Klik "Konfirmasi Verifikasi"
9. Sistem akan mengirim notifikasi ke pelanggan (email + WhatsApp)

### C. Membuat Pengaduan (untuk Pelanggan Terverifikasi)
1. Login sebagai pelanggan (contoh: pelanggan1@pdam.local / customer123)
2. Klik "Buat Pengaduan Baru" atau buka http://127.0.0.1:8000/pengaduan/create
3. Isi form pengaduan:
   - Jenis Pengaduan (Pipa Bocor, Air Keruh, Meteran Error, Tagihan Salah, Lainnya)
   - Judul Pengaduan
   - Deskripsi Gangguan
   - Lokasi
   - Foto Bukti (opsional)
4. Klik "Kirim Laporan"
5. Sistem akan:
   - Generate nomor pengaduan (format: PDAM-XXXXXX)
   - Simpan pengaduan dengan status "menunggu"
   - Kirim notifikasi ke admin

### D. Verifikasi dan Penugasan (untuk Admin)
1. Login sebagai admin
2. Buka menu "Kelola Pengaduan" atau http://127.0.0.1:8000/admin/pengaduan
3. Klik detail pengaduan yang ingin ditangani
4. Jika status "menunggu", pilih petugas di form "Tugaskan Petugas"
5. Klik "Tugaskan & Proses"
6. Status akan berubah menjadi "diproses"
7. Petugas akan menerima notifikasi

### E. Penanganan Pengaduan (untuk Petugas)
1. Login sebagai petugas (contoh: petugas1@pdam.local / petugas123)
2. Dashboard menampilkan pengaduan yang ditugaskan
3. Klik ikon "Sync" untuk update status
4. Pilih status baru:
   - Diproses (sedang ditangani)
   - Selesai (sudah selesai)
   - Ditolak (tidak dapat ditangani)
5. Tambahkan keterangan
6. Klik "Update Status"
7. Sistem akan:
   - Update status pengaduan
   - Tambah riwayat tracking
   - Kirim notifikasi ke pelanggan

### F. Pelacakan Status (untuk Pelanggan)
1. Login sebagai pelanggan
2. Buka "Riwayat Pengaduan" atau dashboard
3. Klik "Detail" pada pengaduan yang ingin dilacak
4. Lihat:
   - Informasi lengkap pengaduan
   - Riwayat perubahan status
   - Keterangan dari petugas
   - Timestamp setiap perubahan

## Fitur Utama yang Tersedia

### 1. Multi-Role Access
- **Admin**: Full access ke semua fitur
- **Petugas**: Hanya pengaduan yang ditugaskan
- **Pelanggan**: Hanya pengaduan milik sendiri

### 2. Notifikasi Otomatis
- **Email**: Notifikasi status perubahan
- **WhatsApp**: Notifikasi penting (verifikasi, pengaduan baru)

### 3. Tracking Real-Time
- Riwayat lengkap perubahan status
- Timestamp untuk setiap update
- Informasi petugas yang menangani

### 4. Validasi Data
- Form validation di semua input
- File upload validation (format, size)
- Unique constraint (email, nomor meteran)

### 5. Security
- Password hashing (bcrypt)
- CSRF protection
- Role-based access control
- Input sanitization

## Struktur URL

### Public
- `/` - Home page
- `/login` - Halaman login
- `/register` - Halaman registrasi
- `/help` - Panduan penggunaan

### Pelanggan (setelah login)
- `/dashboard` - Dashboard pelanggan
- `/pengaduan` - Daftar pengaduan
- `/pengaduan/create` - Buat pengaduan baru
- `/pengaduan/{id}` - Detail pengaduan

### Petugas (setelah login)
- `/petugas/dashboard` - Dashboard petugas

### Admin (setelah login)
- `/admin/dashboard` - Dashboard admin
- `/admin/pelanggan` - Kelola pelanggan
- `/admin/pelanggan/belum-verifikasi` - Verifikasi pelanggan
- `/admin/pengaduan` - Kelola pengaduan
- `/admin/petugas` - Kelola petugas
- `/admin/notifikasi` - Daftar notifikasi
- `/admin/monitoring` - Monitoring sistem
- `/admin/laporan` - Generate laporan

## Troubleshooting

### Error: "Akun Anda belum diverifikasi"
- **Penyebab**: Akun pelanggan belum diverifikasi oleh admin
- **Solusi**: Hubungi admin untuk verifikasi

### Error: "Data pelanggan tidak ditemukan"
- **Penyebab**: User login sebagai pelanggan tapi tidak ada data di tabel pelanggan
- **Solusi**: Hubungi admin untuk membuat data pelanggan

### Error: "Tidak ada pengaduan yang ditugaskan"
- **Penyebab**: Belum ada pengaduan yang di-assign ke petugas
- **Solusi**: Tunggu admin menugaskan pengaduan

## Catatan Penting

1. **Foto UTP**: Wajib diupload saat registrasi, digunakan untuk verifikasi
2. **Nomor Pengaduan**: Digenerate otomatis dengan format PDAM-XXXXXX
3. **Notifikasi WhatsApp**: Memerlukan konfigurasi WhatsApp Service
4. **Database**: Menggunakan SQLite (file: database/database.sqlite)
5. **Storage**: File upload disimpan di storage/app/public

## Development

### Melihat Log
```bash
# Laravel log
tail -f storage/logs/laravel.log
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Reset Database
```bash
php artisan migrate:fresh --seed
```

## Kontak Support
- Email: support@pdam.local
- Telp: 0812-3456-7890

---
**Sistem Informasi Pengaduan PDAM Tirta Albantani Cabang Cijeruk**
**Version 1.0 - 2026**
