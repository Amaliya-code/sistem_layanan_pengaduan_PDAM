@extends('layouts.app')

@section('title', 'Dashboard Saya')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">
                <i class="fas fa-tachometer-alt text-primary"></i>
                Dashboard Saya
            </h2>
            <small class="text-muted">
                Pantau pengaduan Anda
            </small>
        </div>
        <a href="{{ route('pengaduan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Pengaduan Baru
        </a>
    </div>

    {{-- Statistik --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Menunggu</h5>
                    <h2 class="fw-bold">{{ $stats['menunggu'] ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Diproses</h5>
                    <h2 class="fw-bold">{{ $stats['diproses'] ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Selesai</h5>
                    <h2 class="fw-bold">{{ $stats['selesai'] ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total</h5>
                    <h2 class="fw-bold">{{ $stats['total'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Pesan --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Pengaduan Terbaru --}}
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-clipboard-list"></i>
                Pengaduan Terbaru
            </span>
            <a href="{{ route('pengaduan.index') }}" class="btn btn-light btn-sm">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="card-body">
            @if(isset($pengaduans) && $pengaduans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nomor Pengaduan</th>
                                <th>Jenis</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengaduans as $index => $pengaduan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $pengaduan->nomor_pengaduan }}</strong>
                                    </td>
                                    <td>{{ $pengaduan->jenis_pengaduan }}</td>
                                    <td>{{ Str::limit($pengaduan->judul_pengaduan, 50) }}</td>
                                    <td>
                                        @if($pengaduan->status == 'menunggu')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-clock"></i> Menunggu
                                            </span>
                                        @elseif($pengaduan->status == 'diproses')
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-spinner"></i> Diproses
                                            </span>
                                        @elseif($pengaduan->status == 'selesai')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Selesai
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times"></i> Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $pengaduan->tanggal_pengaduan->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('pengaduan.show', $pengaduan) }}"
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5>Belum Ada Pengaduan</h5>
                    <p class="text-muted">Anda belum membuat pengaduan. Klik tombol di atas untuk membuat pengaduan baru.</p>
                    <a href="{{ route('pengaduan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Pengaduan Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
