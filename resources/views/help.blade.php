@extends('layouts.app')

@section('title', 'Panduan Pengguna')

@section('content')
<div class="container py-6">
    <h1 class="mb-4">Panduan Pengguna — Sistem Pengaduan PDAM</h1>

    <section class="mb-4">
        <h4>1. Halaman Beranda</h4>
        <p>Menampilkan informasi layanan, alur aplikasi, dan akses cepat untuk Login/Register serta pembuatan pengaduan.</p>
    </section>

    <section class="mb-4">
        <h4>2. Registrasi Pelanggan</h4>
        <p>Pelanggan mengisi: nama, nomor pelanggan, alamat, no. telepon, email, username, dan password. Setelah daftar, pelanggan dapat membuat pengaduan.</p>
    </section>

    <section class="mb-4">
        <h4>3. Login</h4>
        <p>Login menggunakan email/username dan password. Hak akses menentukan dashboard yang terbuka (Admin, Petugas, Pelanggan).</p>
    </section>

    <section class="mb-4">
        <h4>4. Pengajuan Pengaduan</h4>
        <p>Form pengaduan: jenis pengaduan, judul, deskripsi, lokasi, dan upload foto bukti. Status awal: <strong>menunggu</strong>.</p>
    </section>

    <section class="mb-4">
        <h4>5. Tracking Pengaduan</h4>
        <p>Setiap perubahan status disimpan di tabel <code>tracking_pengaduan</code> dengan keterangan dan timestamp. Pelanggan dapat melihat riwayat tersebut di halaman riwayat pengaduan.</p>
    </section>

    <section class="mb-4">
        <h4>6. Peran Admin</h4>
        <ul>
            <li>Verifikasi pengaduan yang masuk.</li>
            <li>Menugaskan petugas.</li>
            <li>Mengubah status dan membuat laporan per periode.</li>
            <li>Mengelola data pelanggan dan petugas.</li>
        </ul>
    </section>

    <section class="mb-4">
        <h4>7. Peran Petugas</h4>
        <p>Melihat pengaduan yang ditugaskan, memperbarui status, dan menambahkan keterangan hasil penanganan.</p>
    </section>

    <section class="mb-4">
        <h4>8. Notifikasi</h4>
        <p>Sistem mengirim notifikasi via Email atau WhatsApp ketika status pengaduan berubah. Notifikasi tersimpan di tabel <code>notifikasi</code>.</p>
    </section>

    <section class="mb-4">
        <h4>9. Laporan</h4>
        <p>Admin dapat menghasilkan laporan berdasarkan periode (bulan/tahun) yang berisi jumlah pengaduan per status dan kategori.</p>
    </section>

    <section class="mb-4">
        <h4>10. Uji Coba (Black Box)</h4>
        <p>Gunakan skenario pengujian untuk memverifikasi fungsionalitas: Login, Registrasi, Pengajuan Pengaduan, Tracking, Verifikasi, Notifikasi, dan Laporan.</p>
    </section>

</div>
@endsection
