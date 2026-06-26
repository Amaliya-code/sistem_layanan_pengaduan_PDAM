@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">
                <i class="fas fa-tools text-primary"></i>
                Dashboard Petugas
            </h2>
            <small class="text-muted">
                Daftar pengaduan yang ditugaskan kepada petugas
            </small>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="row mb-4">

        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Menunggu</h5>
                    <h2 class="fw-bold">{{ $menunggu ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Diproses</h5>
                    <h2 class="fw-bold">{{ $diproses ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Selesai</h5>
                    <h2 class="fw-bold">{{ $selesai ?? 0 }}</h2>
                </div>
            </div>
        </div>

    </div>

    {{-- Pesan --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Pengaduan --}}
    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">
            <i class="fas fa-clipboard-list"></i>
            Daftar Pengaduan Ditugaskan
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Judul Pengaduan</th>
                            <th>Pelanggan</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($pengaduans as $item)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <strong>{{ $item->pengaduan->nomor_pengaduan ?? '-' }}</strong><br>
                                <small>{{ $item->pengaduan->judul_pengaduan ?? '-' }}</small>
                            </td>

                            <td>
                                {{ $item->pengaduan->pelanggan->nama_pelanggan ?? '-' }}
                            </td>

                            <td>
                                {{ $item->pengaduan->lokasi ?? '-' }}
                            </td>

                            <td>
                                @if(($item->pengaduan->status ?? '') == 'menunggu')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-clock"></i> Menunggu
                                    </span>

                                @elseif(($item->pengaduan->status ?? '') == 'diproses')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-spinner"></i> Diproses
                                    </span>

                                @elseif(($item->pengaduan->status ?? '') == 'selesai')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Selesai
                                    </span>

                                @elseif(($item->pengaduan->status ?? '') == 'ditolak')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times"></i> Ditolak
                                    </span>

                                @else
                                    <span class="badge bg-secondary">
                                        {{ $item->pengaduan->status ?? '-' }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_update)->format('d/m/Y H:i') }}
                            </td>

                            <td>
                                <a href="{{ route('pengaduan.show', $item->pengaduan->id_pengaduan) }}"
                                   class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($item->pengaduan->status != 'selesai' && $item->pengaduan->status != 'ditolak')
                                    <button class="btn btn-sm btn-success"
                                            data-bs-toggle="modal"
                                            data-bs-target="#updateStatusModal{{ $item->id_tracking }}"
                                            title="Update Status">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                @endif
                            </td>

                        </tr>

                        <!-- Update Status Modal -->
                        @if($item->pengaduan->status != 'selesai' && $item->pengaduan->status != 'ditolak')
                        <div class="modal fade"
                             id="updateStatusModal{{ $item->id_tracking }}"
                             tabindex="-1"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            <i class="fas fa-sync-alt"></i>
                                            Update Status: {{ $item->pengaduan->nomor_pengaduan }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('tracking.updateStatus', $item) }}"
                                          method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Status Baru:</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="diproses" {{ $item->status == 'diproses' ? 'selected' : '' }}>
                                                        <i class="fas fa-spinner"></i> Diproses
                                                    </option>
                                                    <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>
                                                        <i class="fas fa-check"></i> Selesai
                                                    </option>
                                                    <option value="ditolak" {{ $item->status == 'ditolak' ? 'selected' : '' }}>
                                                        <i class="fas fa-times"></i> Ditolak
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Keterangan:</label>
                                                <textarea name="keterangan"
                                                          class="form-control"
                                                          rows="3"
                                                          required
                                                          placeholder="Jelaskan update status...">{{ old('keterangan') }}</textarea>
                                            </div>

                                            <div class="alert alert-info">
                                                <small>
                                                    <strong>Info Pengaduan:</strong><br>
                                                    Nomor: {{ $item->pengaduan->nomor_pengaduan }}<br>
                                                    Pelanggan: {{ $item->pengaduan->pelanggan->nama_pelanggan ?? '-' }}<br>
                                                    Lokasi: {{ $item->pengaduan->lokasi }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Batal
                                            </button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i> Update Status
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                    @empty

                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-clipboard-check fa-3x mb-3"></i>
                                <p class="mb-0">Belum ada pengaduan yang ditugaskan kepada Anda.</p>
                                <small>Menunggu admin menugaskan pengaduan...</small>
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
@endsection
