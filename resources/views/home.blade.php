@extends('layouts.app')

@section('title', 'Beranda - PDAM')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4 py-12">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Sistem Pengaduan PDAM Tirta Al-Bantani</h1>
            <p class="text-lg text-gray-600">Layanan pelaporan gangguan, pelacakan status, dan manajemen pengaduan.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white p-6 rounded shadow">
                <h3 class="text-2xl font-semibold mb-3">Ringkasan Layanan</h3>
                <p class="text-gray-700">Aplikasi ini mengikuti alur algoritma yang terstruktur untuk memastikan pengaduan ditangani secara transparan dan terdokumentasi.</p>

                <h5 class="mt-4 font-medium">Fitur Utama</h5>
                <ul class="list-disc list-inside mt-2 text-gray-700">
                    <li>Registrasi dan autentikasi pengguna (Pelanggan, Petugas, Admin).</li>
                    <li>Form pengajuan pengaduan dengan upload foto bukti.</li>
                    <li>Verifikasi dan penugasan pengaduan oleh Admin.</li>
                    <li>Tracking status pengaduan dengan riwayat perubahan.</li>
                    <li>Notifikasi otomatis (Email/WhatsApp) saat status berubah.</li>
                    <li>Pembuatan laporan per periode oleh Admin.</li>
                </ul>

                <h5 class="mt-4 font-medium">Alur Algoritma Singkat</h5>
                <ol class="list-decimal list-inside mt-2 text-gray-700">
                    <li>Simpan pengaduan di tabel `pengaduan` dengan status awal `menunggu`.</li>
                    <li>Buat record awal di `tracking_pengaduan`.</li>
                    <li>Admin memverifikasi dan menugaskan petugas; ubah status menjadi `diproses`.</li>
                    <li>Petugas memperbarui status; setiap perubahan menambah `tracking_pengaduan` dan membuat `notifikasi`.</li>
                    <li>Admin dapat mengekspor laporan berdasarkan periode dari tabel `pengaduan`.</li>
                </ol>

                <p class="mt-4">Untuk panduan lengkap dan rancangan input/output, buka halaman <a href="{{ route('help') }}" class="text-blue-600 underline">Panduan Pengguna</a>.</p>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h4 class="font-semibold mb-3">Aksi Cepat</h4>
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary d-block mb-2">Dashboard Admin</a>
                    @elseif(Auth::user()->isPetugas())
                        <a href="{{ route('petugas.dashboard') }}" class="btn btn-primary d-block mb-2">Dashboard Petugas</a>
                    @else
                        <a href="{{ route('pengaduan.create') }}" class="btn btn-success d-block mb-2">Buat Pengaduan</a>
                        <a href="{{ route('pengaduan.index') }}" class="btn btn-outline-secondary d-block">Riwayat Pengaduan</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary d-block mb-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary d-block">Daftar</a>
                @endauth

                <hr class="my-3">
                <h6 class="font-medium">Kontak Layanan</h6>
                <p class="text-sm text-gray-700">Telp/WA: 0812-3456-7890<br>Email: layanan@pdam.local</p>
            </div>
        </div>
    </div>
</div>
@endsection
