@extends('layouts.app')

@section('title', 'Registrasi Pelanggan PDAM')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <div class="card border-0 shadow-lg rounded-4">

                <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                    <h2 class="mb-0">
                        💧 Registrasi Pelanggan PDAM
                    </h2>
                    <small>Buat akun untuk mengajukan pengaduan</small>
                </div>

                <div class="card-body p-4">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                name="nama"
                                class="form-control form-control-lg @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}"
                                required
                            >
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input
                                type="email"
                                name="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Nomor WhatsApp
                            </label>
                            <input
                                type="text"
                                name="whatsapp"
                                class="form-control form-control-lg @error('whatsapp') is-invalid @enderror"
                                placeholder="08xxxxxxxxxx"
                                value="{{ old('whatsapp') }}"
                            >
                            @error('whatsapp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Nomor Meteran / Nomor Pelanggan <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                name="nomor_meteran"
                                class="form-control form-control-lg @error('nomor_meteran') is-invalid @enderror"
                                value="{{ old('nomor_meteran') }}"
                                required
                            >
                            @error('nomor_meteran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Alamat <span class="text-danger">*</span>
                            </label>
                            <textarea
                                name="alamat"
                                class="form-control form-control-lg @error('alamat') is-invalid @enderror"
                                rows="3"
                                required
                            >{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                No. Telepon <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                name="no_telepon"
                                class="form-control form-control-lg @error('no_telepon') is-invalid @enderror"
                                value="{{ old('no_telepon') }}"
                                required
                            >
                            @error('no_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Foto UTP (Bukti Kepemilikan) <span class="text-danger">*</span>
                            </label>
                            <input
                                type="file"
                                name="foto_utp"
                                class="form-control @error('foto_utp') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg"
                                required
                            >
                            <small class="form-text text-muted">
                                Upload foto UTP (Uji Tanda Penerimaan Pipa) atau bukti kepemilikan rumah. Format: JPG, PNG. Max: 2MB
                            </small>
                            @error('foto_utp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Password <span class="text-danger">*</span>
                            </label>
                            <input
                                type="password"
                                name="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                required
                                minlength="8"
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control form-control-lg"
                                required
                                minlength="8"
                            >
                        </div>

                        <div class="alert alert-info">
                            <small>
                                <i class="fas fa-info-circle"></i>
                                <strong>Informasi:</strong> Setelah mendaftar, akun Anda akan diverifikasi oleh admin sebelum dapat digunakan. Proses verifikasi memerlukan foto UTP yang valid.
                            </small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus"></i>
                                Daftar Sekarang
                            </button>
                        </div>

                    </form>

                    <hr>

                    <div class="text-center">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                           class="text-decoration-none fw-bold">
                            Login di sini
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
