<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pelanggan;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        $namaPelanggan = [
            'Ahmad Fauzi',
            'Siti Nurhaliza',
            'Rizky Pratama',
            'Dewi Lestari',
            'Agus Setiawan',
            'Rina Marlina',
            'Eko Prasetyo',
            'Yuni Kartika',
            'Fajar Ramadhan',
            'Lilis Suryani',
            'Hendra Gunawan',
            'Nina Oktaviani',
            'Bayu Saputra',
            'Maya Sari',
            'Asep Hidayat',
            'Fitri Handayani',
            'Doni Kurniawan',
            'Indah Permata',
            'Rudi Hermawan',
            'Sri Wahyuni',
        ];

        foreach ($namaPelanggan as $index => $nama) {

            $nomor = $index + 1;

            $user = User::firstOrCreate(
                [
                    'email' => "pelanggan{$nomor}@pdam.local"
                ],
                [
                    'nama' => $nama,
                    'password' => Hash::make('pelanggan123'),
                    'role' => 'pelanggan',
                ]
            );

            Pelanggan::firstOrCreate(
                [
                    'id_user' => $user->id_user
                ],
                [
                    'nomor_pelanggan' => 'PLG' . str_pad($nomor, 4, '0', STR_PAD_LEFT),
                    'nama_pelanggan' => $nama,
                    'alamat' => 'Jl. Raya Serang No. ' . $nomor,
                    'no_telepon' => '08123' . str_pad($nomor, 7, '0', STR_PAD_LEFT),
                ]
            );
        }
    }
}
