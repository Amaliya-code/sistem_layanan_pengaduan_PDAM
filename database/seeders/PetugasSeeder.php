<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Petugas;

class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        $dataPetugas = [
            [
                'nama' => 'Andi Saputra',
                'email' => 'andi@pdam.local',
                'jabatan' => 'Petugas Lapangan',
                'telepon' => '081234567891',
            ],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi@pdam.local',
                'jabatan' => 'Petugas Lapangan',
                'telepon' => '081234567892',
            ],
            [
                'nama' => 'Dedi Kurniawan',
                'email' => 'dedi@pdam.local',
                'jabatan' => 'Petugas Lapangan',
                'telepon' => '081234567893',
            ],
            [
                'nama' => 'Rudi Hartono',
                'email' => 'rudi@pdam.local',
                'jabatan' => 'Koordinator Lapangan',
                'telepon' => '081234567894',
            ],
        ];

        foreach ($dataPetugas as $data) {

            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'nama' => $data['nama'],
                    'password' => Hash::make('petugas123'),
                    'role' => 'petugas',
                ]
            );

            Petugas::firstOrCreate(
                ['id_user' => $user->id_user],
                [
                    'nama_petugas' => $data['nama'],
                    'jabatan' => $data['jabatan'],
                    'no_telepon' => $data['telepon'],
                ]
            );
        }
    }
}
