<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Petugas;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        \App\Models\TrackingPengaduan::query()->delete();
        \App\Models\Pengaduan::query()->delete();
        \App\Models\Pelanggan::query()->delete();
        \App\Models\Petugas::query()->delete();
        \App\Models\User::query()->delete();

        // Create Admin
        $admin = User::create([
            'nama' => 'Admin PDAM',
            'email' => 'admin@pdam.local',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'whatsapp' => '6281234567890'
        ]);

        // Create 3 Petugas
        for ($i = 1; $i <= 3; $i++) {
            $user = User::create([
                'nama' => "Petugas $i",
                'email' => "petugas$i@pdam.local",
                'password' => bcrypt('petugas123'),
                'role' => 'petugas',
                'whatsapp' => '628123456789' . $i
            ]);

            Petugas::create([
                'id_user' => $user->id_user,
                'nama_petugas' => "Petugas $i",
                'jabatan' => 'Staff Lapangan',
                'no_telepon' => '081234567' . str_pad($i, 2, '0', STR_PAD_LEFT)
            ]);
        }

        // Create 10 Sample Pelanggan (with verification for testing)
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'nama' => "Pelanggan $i",
                'email' => "pelanggan$i@pdam.local",
                'password' => bcrypt('customer123'),
                'role' => 'pelanggan',
                'whatsapp' => '628123456789' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'status_verifikasi' => true, // Auto-verify for testing
                'foto_ktp' => null
            ]);

            Pelanggan::create([
                'id_user' => $user->id_user,
                'nomor_pelanggan' => '1234560' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nama_pelanggan' => "Pelanggan $i",
                'alamat' => "Jalan Merdeka No. $i, Serang",
                'no_telepon' => '0812345678' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'foto_utp' => null
            ]);
        }

        // Create 3 Sample Pengaduan for testing
        for ($i = 1; $i <= 3; $i++) {
            $pelanggan = Pelanggan::where('nomor_pelanggan', '1234560000' . $i)->first();

            if ($pelanggan) {
                $pengaduan = \App\Models\Pengaduan::create([
                    'id_pelanggan' => $pelanggan->id_pelanggan,
                    'nomor_pengaduan' => \App\Models\Pengaduan::generateNomorPengaduan(),
                    'jenis_pengaduan' => ['Pipa Bocor', 'Air Keruh', 'Meteran Error'][$i - 1],
                    'judul_pengaduan' => "Pengaduan Test $i - Gangguan PDAM",
                    'deskripsi' => "Ini adalah pengaduan testing untuk keperluan demonstrasi sistem. Nomor pelanggan: {$pelanggan->nomor_pelanggan}",
                    'lokasi' => "Jalan Merdeka No. $i, Serang",
                    'foto_bukti' => null,
                    'status' => ['menunggu', 'diproses', 'selesai'][$i - 1],
                    'tanggal_pengaduan' => now()->subDays(rand(1, 10))
                ]);

                // Create tracking record
                \App\Models\TrackingPengaduan::create([
                    'id_pengaduan' => $pengaduan->id_pengaduan,
                    'id_petugas' => $i <= 2 ? $i : null,
                    'status' => $pengaduan->status,
                    'keterangan' => 'Testing data',
                    'tanggal_update' => $pengaduan->tanggal_pengaduan
                ]);
            }
        }
    }

}
?>
