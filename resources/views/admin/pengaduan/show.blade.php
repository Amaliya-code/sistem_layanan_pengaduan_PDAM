@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">📋 Detail Pengaduan</h2>
            <p class="text-muted">Kelola dan pantau pengaduan pelanggan</p>
        </div>
        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="row">
        <!-- Main Information -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt"></i> Informasi Pengaduan
                    </h5>
                    <span class="badge bg-{{ $pengaduan->status == 'selesai' ? 'success' : ($pengaduan->status == 'diproses' ? 'warning' : ($pengaduan->status == 'ditolak' ? 'danger' : 'secondary')) }}">
                        {{ ucfirst($pengaduan->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Nomor Pengaduan:</strong><br>
                            <code class="fs-5">{{ $pengaduan->nomor_pengaduan }}</code>
                        </div>
                        <div class="col-md-6">
                            <strong>Tanggal Pengaduan:</strong><br>
                            {{ $pengaduan->tanggal_pengaduan->format('d M Y H:i') }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Jenis Pengaduan:</strong><br>
                            {{ $pengaduan->jenis_pengaduan }}
                        </div>
                        <div class="col-md-6">
                            <strong>Pelapor:</strong><br>
                            {{ $pengaduan->pelanggan->nama_pelanggan ?? 'Tidak diketahui' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Judul Pengaduan:</strong><br>
                        <h5>{{ $pengaduan->judul_pengaduan }}</h5>
                    </div>

                    <div class="mb-3">
                        <strong>Deskripsi:</strong><br>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($pengaduan->deskripsi)) !!}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Lokasi:</strong><br>
                            <i class="fas fa-map-marker-alt text-danger"></i> {{ $pengaduan->lokasi }}
                        </div>
                    </div>

                    @if($pengaduan->foto_bukti)
                        <div class="mb-3">
                            <strong>Foto Bukti:</strong><br>
                            <a href="{{ asset('storage/' . $pengaduan->foto_bukti) }}" target="_blank">
                                <img src="{{ asset('storage/' . $pengaduan->foto_bukti) }}"
                                     class="img-thumbnail mt-2"
                                     style="max-height: 400px; max-width: 100%;">
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tracking History -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-history"></i> Riwayat Status Pengaduan
                    </h5>
                </div>
                <div class="card-body">
                    @if($pengaduan->trackingPengaduans->count() > 0)
                        <div class="timeline">
                            @foreach($pengaduan->trackingPengaduans->sortByDesc('tanggal_update') as $tracking)
                                <div class="card mb-3 border-start border-4 border-{{ $tracking->status == 'selesai' ? 'success' : ($tracking->status == 'diproses' ? 'warning' : ($tracking->status == 'ditolak' ? 'danger' : 'secondary')) }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">
                                                    <span class="badge bg-{{ $tracking->status == 'selesai' ? 'success' : ($tracking->status == 'diproses' ? 'warning' : ($tracking->status == 'ditolak' ? 'danger' : 'secondary')) }}">
                                                        {{ ucfirst($tracking->status) }}
                                                    </span>
                                                </h6>
                                                <p class="mb-1">{{ $tracking->keterangan }}</p>
                                                @if($tracking->petugas)
                                                    <small class="text-muted">
                                                        <i class="fas fa-user"></i> Petugas: {{ $tracking->petugas->nama }}
                                                    </small>
                                                @endif
                                            </div>
                                            <small class="text-muted">
                                                {{ $tracking->tanggal_update->format('d M Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center">Belum ada riwayat tracking</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar - Actions -->
        <div class="col-lg-4">
            <!-- Assign Petugas -->
            @if($pengaduan->status == 'menunggu')
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0">
                            <i class="fas fa-user-plus"></i> Tugaskan Petugas
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.pengaduan.assign', $pengaduan) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Pilih Petugas:</label>
                                <select name="id_petugas" class="form-select" required>
                                    <option value="">-- Pilih Petugas --</option>
                                    @foreach(\App\Models\Petugas::all() as $petugas)
                                        <option value="{{ $petugas->id_petugas }}">
                                            {{ $petugas->nama }} - {{ $petugas->jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-check"></i> Tugaskan & Proses
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Update Status -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-sync-alt"></i> Update Status
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pengaduan.updateStatus', $pengaduan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Status Baru:</label>
                            <select name="status" class="form-select" required>
                                <option value="menunggu" {{ $pengaduan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan:</label>
                            <textarea name="keterangan" class="form-control" rows="3" required placeholder="Jelaskan perubahan status..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Pelanggan Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-user"></i> Informasi Pelanggan
                    </h6>
                </div>
                <div class="card-body">
                    @if($pengaduan->pelanggan)
                        <p><strong>Nama:</strong><br>{{ $pengaduan->pelanggan->nama_pelanggan }}</p>
                        <p><strong>No. Pelanggan:</strong><br>
                            <code>{{ $pengaduan->pelanggan->nomor_pelanggan }}</code>
                        </p>
                        <p><strong>Alamat:</strong><br>{{ $pengaduan->pelanggan->alamat }}</p>
                        <p><strong>No. Telepon:</strong><br>{{ $pengaduan->pelanggan->no_telepon ?? '-' }}</p>
                        @if($pengaduan->pelanggan->user)
                            <p><strong>Email:</strong><br>{{ $pengaduan->pelanggan->user->email }}</p>
                        @endif
                    @else
                        <p class="text-muted">Data pelanggan tidak tersedia</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
