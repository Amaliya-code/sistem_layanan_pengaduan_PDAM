@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">
                <i class="fas fa-tachometer-alt text-primary"></i>
                Dashboard Admin
            </h2>
            <small class="text-muted">
                Kelola sistem pengaduan PDAM Tirta Albantani
            </small>
        </div>
        <div>
            <a href="{{ route('admin.pelanggan.belum-verifikasi') }}" class="btn btn-warning me-2">
                <i class="fas fa-clock"></i> Verifikasi Pelanggan
                @php
                    $countVerifikasi = \App\Models\Pelanggan::whereHas('user', function($q) {
                        $q->where('status_verifikasi', false);
                    })->count();
                @endphp
                @if($countVerifikasi > 0)
                    <span class="badge bg-danger">{{ $countVerifikasi }}</span>
                @endif
            </a>
            <a href="{{ route('admin.laporan') }}" class="btn btn-success">
                <i class="fas fa-file-pdf"></i> Generate Laporan
            </a>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pelanggan</h5>
                    <h2 class="fw-bold">{{ $stats['total_pelanggan'] ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pengaduan</h5>
                    <h2 class="fw-bold">{{ $stats['total_pengaduan'] ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Menunggu</h5>
                    <h2 class="fw-bold">{{ $stats['menunggu'] ?? 0 }}</h2>
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
    </div>

    {{-- Pesan --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Menu Cepat --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fas fa-bolt"></i> Menu Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-users"></i> Kelola Pelanggan
                        </a>
                        <a href="{{ route('admin.petugas.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-user-cog"></i> Kelola Petugas
                        </a>
                        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline-success">
                            <i class="fas fa-clipboard-list"></i> Kelola Pengaduan
                        </a>
                        <a href="{{ route('admin.pelanggan.belum-verifikasi') }}" class="btn btn-outline-warning">
                            <i class="fas fa-user-check"></i> Verifikasi Pelanggan
                        </a>
                        <a href="{{ route('admin.notifikasi.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-bell"></i> Notifikasi
                        </a>
                        <a href="{{ route('admin.monitoring') }}" class="btn btn-outline-dark">
                            <i class="fas fa-chart-line"></i> Monitoring
                        </a>
                        <a href="{{ route('admin.laporan') }}" class="btn btn-outline-danger">
                            <i class="fas fa-file-alt"></i> Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pengaduan Terbaru --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-clipboard-list"></i>
                        Pengaduan Terbaru
                    </span>
                    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-light btn-sm">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($pengaduan_terbaru) && $pengaduan_terbaru->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Pengaduan</th>
                                        <th>Pelanggan</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengaduan_terbaru as $index => $p)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $p->nomor_pengaduan }}</strong>
                                            </td>
                                            <td>{{ $p->pelanggan->nama_pelanggan ?? '-' }}</td>
                                            <td>{{ $p->jenis_pengaduan }}</td>
                                            <td>
                                                @if($p->status == 'menunggu')
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-clock"></i> Menunggu
                                                    </span>
                                                @elseif($p->status == 'diproses')
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-spinner"></i> Diproses
                                                    </span>
                                                @elseif($p->status == 'selesai')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check"></i> Selesai
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times"></i> Ditolak
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $p->tanggal_pengaduan->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('admin.pengaduan.show', $p->id_pengaduan) }}"
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
                            <p class="text-muted">Belum ada pengaduan yang masuk ke sistem</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
