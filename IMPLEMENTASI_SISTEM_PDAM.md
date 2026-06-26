# Dokumentasi Implementasi Sistem Informasi Pengaduan PDAM

## Ringkasan
Sistem Informasi Pengaduan PDAM Tirta Albantani Cabang Cijeruk telah diimplementasikan sesuai dengan desain algoritma dan arsitektur yang telah ditentukan.

## Fitur yang Telah Diimplementasikan

### 1. ✅ Pendaftaran & Login Pelanggan
- **Registrasi dengan UTP**: Pelanggan dapat mendaftar dengan upload foto UTP (Uji Tanda Penerimaan Pipa)
- **Validasi Data**: Sistem validasi data pendaftaran (nama, email, nomor meteran, alamat, dll)
- **Verifikasi Admin**: Akun pelanggan harus diverifikasi oleh admin sebelum dapat login
- **Login dengan Role-based Access**: Redirect otomatis berdasarkan role (admin/petugas/pelanggan)

### 2. ✅ Pengajuan Pengaduan
- **Form Pengaduan Lengkap**: 
  - Jenis pengaduan (Pipa Bocor, Air Keruh, Meteran Error, Tagihan Salah, Lainnya)
  - Judul dan deskripsi
  - Lokasi
  - Upload foto bukti (opsional)
- **Nomor Pengaduan Otomatis**: Generate nomor pengaduan format PDAM-XXXXXX
- **Validasi Form**: Validasi input sebelum disimpan
- **Notifikasi Admin**: Kirim notifikasi email dan WhatsApp ke admin saat ada pengaduan baru

### 3. ✅ Verifikasi Admin & Penugasan Petugas
- **Dashboard Verifikasi**: Admin dapat melihat daftar pelanggan yang menunggu verifikasi
- **Proses Verifikasi**: 
  - Approve/Reject pendaftaran pelanggan
  - Tambahkan catatan verifikasi
  - Notifikasi otomatis ke pelanggan (email + WhatsApp)
- **Penugasan Petugas**: Admin dapat menugaskan petugas untuk menangani pengaduan
- **Update Status**: Admin dapat mengubah status pengaduan

### 4. ✅ Penanganan Petugas & Update Real-Time
- **Dashboard Petugas**: Menampilkan pengaduan yang ditugaskan
- **Update Status**: Petugas dapat update status pengaduan
- **Tracking History**: Riwayat lengkap perubahan status pengaduan
- **Notifikasi Pelanggan**: Otomatis kirim notifikasi saat status berubah

### 5. ✅ Pelacakan Status & Penyelesaian
- **Tracking Real-Time**: Pelacakan status pengaduan secara real-time
- **Riwayat Lengkap**: Timeline perubahan status dengan timestamp
- **Notifikasi Multi-channel**: Email dan WhatsApp notification
- **Dashboard Monitoring**: Admin dapat memantau semua pengaduan

## Struktur Database

### Tabel Users
- id_user (Primary Key)
- nama
- email
- password
- role (admin/petugas/pelanggan)
- whatsapp
- status_verifikasi (boolean)
- foto_ktp
- timestamps

### Tabel Pelanggan
- id_pelanggan (Primary Key)
- id_user (Foreign Key)
- nomor_pelanggan (nomor meteran)
- nama_pelanggan
- alamat
- no_telepon
- foto_utp
- timestamps

### Tabel Pengaduans
- id_pengaduan (Primary Key)
- id_pelanggan (Foreign Key)
- nomor_pengaduan (PDAM-XXXXXX)
- jenis_pengaduan
- judul_pengaduan
- deskripsi
- lokasi
- foto_bukti
- status (menunggu/diproses/selesai/ditolak)
- tanggal_pengaduan
- timestamps

### Tabel Tracking Pengaduan
- id_tracking (Primary Key)
- id_pengaduan (Foreign Key)
- id_petugas (Foreign Key, nullable)
- status
- keterangan
- tanggal_update
- timestamps

### Tabel Notifikasi
- id_notifikasi (Primary Key)
- id_pengaduan (Foreign Key, nullable)
- penerima (email/nomor WA)
- jenis_notifikasi (email/whatsapp)
- pesan
- tanggal_kirim
- timestamps

## Alur Sistem

### Alur Registrasi Pelanggan
1. Pelanggan buka website dan klik registrasi
2. Isi form dengan data lengkap + upload foto UTP
3. Sistem simpan data dengan status_verifikasi = false
4. Admin terima notifikasi WhatsApp tentang pendaftaran baru
5. Admin verifikasi data pelanggan (approve/reject)
6. Sistem kirim notifikasi ke pelanggan
7. Pelanggan dapat login setelah diverifikasi

### Alur Pengaduan
1. Pelanggan login ke sistem
2. Pilih menu "Pengaduan Baru"
3. Isi form pengaduan (jenis, judul, deskripsi, lokasi, foto bukti)
4. Sistem validasi dan simpan pengaduan
5. Generate nomor pengaduan otomatis
6. Kirim notifikasi ke admin
7. Admin verifikasi dan tugaskan petugas
8. Petugas terima notifikasi dan tangani pengaduan
9. Update status secara real-time
10. Pelanggan dapat melacak status pengaduan

## File yang Telah Dimodifikasi/Dibuat

### Controllers
- `app/Http/Controllers/AuthController.php` - Login, register dengan verifikasi
- `app/Http/Controllers/AdminController.php` - Verifikasi pelanggan, kelola pengaduan
- `app/Http/Controllers/PengaduanController.php` - CRUD pengaduan
- `app/Http/Controllers/PetugasController.php` - Dashboard petugas

### Models
- `app/Models/User.php` - Tambah field status_verifikasi, foto_ktp
- `app/Models/Pelanggan.php` - Tambah field foto_utp
- `app/Models/Pengaduan.php` - Model pengaduan (sudah ada)
- `app/Models/TrackingPengaduan.php` - Model tracking (sudah ada)
- `app/Models/Notifikasi.php` - Model notifikasi (sudah ada)

### Migrations
- `database/migrations/2026_06_26_add_verification_fields_to_users_and_pelanggan.php` - Tambah kolom verifikasi

### Routes
- `routes/web.php` - Routes untuk verifikasi pelanggan

### Views
- `resources/views/auth/register.blade.php` - Form registrasi dengan upload UTP
- `resources/views/admin/pelanggan/belum-verifikasi.blade.php` - Halaman verifikasi pelanggan
- `resources/views/admin/pelanggan/index.blade.php` - Daftar pelanggan dengan status verifikasi
- `resources/views/admin/pengaduan/show.blade.php` - Detail pengaduan dengan tracking

## Cara Menjalankan Aplikasi

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Setup Database
```bash
# Edit file .env untuk konfigurasi database
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Buat database SQLite jika belum ada
touch database/database.sqlite

# Jalankan migrasi
php artisan migrate

# Seed data awal (opsional)
php artisan db:seed
```

### 3. Setup Storage
```bash
# Buat symbolic link untuk storage
php artisan storage:link
```

### 4. Jalankan Aplikasi
```bash
# Jalankan server development
php artisan serve

# Atau menggunakan Vite untuk asset compilation
npm run dev
```

### 5. Akses Aplikasi
- Buka browser ke `http://localhost:8000`
- Login sebagai admin untuk mengakses dashboard admin
- Register sebagai pelanggan baru untuk testing

## Testing

### Test Case 1: Registrasi Pelanggan
1. Buka halaman registrasi
2. Isi form lengkap dengan foto UTP
3. Submit form
4. Cek notifikasi WhatsApp admin
5. Login sebagai admin
6. Verifikasi pelanggan baru
7. Cek notifikasi ke pelanggan

### Test Case 2: Pengaduan
1. Login sebagai pelanggan yang sudah terverifikasi
2. Buat pengaduan baru
3. Upload foto bukti
4. Submit pengaduan
5. Cek nomor pengaduan generated
6. Login sebagai admin
7. Tugaskan petugas
8. Login sebagai petugas
9. Update status pengaduan
10. Cek notifikasi ke pelanggan

## Notifikasi WhatsApp
Sistem menggunakan WhatsApp Service untuk mengirim notifikasi:
- Notifikasi pendaftaran pelanggan baru ke admin
- Notifikasi verifikasi ke pelanggan
- Notifikasi pengaduan baru ke admin
- Notifikasi update status ke pelanggan

## Keamanan
- Role-based access control (admin/petugas/pelanggan)
- Password hashing
- CSRF protection
- Input validation
- File upload validation

## Pengembangan Selanjutnya
- [ ] Real-time notification dengan WebSocket
- [ ] Dashboard analytics dengan chart
- [ ] Export laporan ke PDF/Excel
- [ ] Mobile app
- [ ] Integration dengan sistem PDAM lain
- [ ] Backup dan restore database
- [ ] Audit log

## Kontak
Untuk pertanyaan atau masalah, hubungi tim pengembang.
