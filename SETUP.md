# Setup dan Instalasi PDAM Application

## Prasyarat
- PHP 8.2 atau lebih tinggi
- Composer (PHP Package Manager)
- Node.js 18+ dan npm
- SQLite (sudah built-in di PHP)

## Langkah-Langkah Instalasi

### 1. Install Dependencies PHP
```bash
composer install
```

### 2. Generate Application Key (jika belum ada)
```bash
php artisan key:generate
```

### 3. Setup Database
Database sudah menggunakan SQLite yang lebih mudah disetup. Jalankan migration:
```bash
php artisan migrate
```

Atau jika ingin reset database dengan data dummy:
```bash
php artisan migrate:fresh --seed
```

### 4. Install Frontend Dependencies
```bash
npm install
```

### 5. Build Frontend Assets
Untuk production:
```bash
npm run build
```

Atau untuk development dengan hot reload:
```bash
npm run dev
```

### 6. Jalankan Server Development
Di terminal terpisah, jalankan:
```bash
php artisan serve
```

Server akan berjalan di: `http://127.0.0.1:8000`

## Menjalankan Semuanya Sekaligus (Development)

Jika Anda memiliki `concurrently` terinstall secara global:
```bash
composer dev
```

Ini akan menjalankan:
- PHP Development Server
- Queue Listener
- Application Logs
- Vite Development Server

## Konfigurasi Environment

File `.env` sudah dikonfigurasi dengan:
- Database: SQLite (file: `database/database.sqlite`)
- Mail: Log Driver (output ke log file untuk testing)
- Debug: Enabled (untuk development)

Jika ingin mengubah konfigurasi email (untuk production), edit file `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

## Troubleshooting

### Error: "Class not found"
```bash
composer dump-autoload
```

### Database error
```bash
php artisan migrate:reset
php artisan migrate:fresh --seed
```

### Frontend tidak muncul
```bash
npm install
npm run build
```

### Cache issues
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Database Structure

Database sudah berisi tabel-tabel untuk:
- Users & Authentication
- Sessions
- Password Resets
- Jobs & Failed Jobs
- Cache
- Dan table khusus aplikasi lainnya

## Troubleshooting Akses Database

Jika ada error koneksi database, pastikan:
1. File `database/database.sqlite` memiliki permission write (644 atau 666)
2. Folder `database/` memiliki permission write (755)
3. Folder `storage/` memiliki permission write (755)

```bash
chmod -R 755 database storage bootstrap/cache
chmod 666 database/database.sqlite
```

## Production Deployment

Untuk production, ikuti langkah-langkah ini:

1. Set .env ke production:
```
APP_ENV=production
APP_DEBUG=false
```

2. Optimize application:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Gunakan web server yang proper (Apache/Nginx) bukan built-in server
4. Setup proper database backup mechanism
5. Setup proper email configuration

## Support & Documentation
- Laravel Documentation: https://laravel.com/docs
- PDAM Application Documentation: Lihat file-file diagram (.md) di root folder
