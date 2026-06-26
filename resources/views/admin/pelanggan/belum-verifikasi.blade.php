@extends('layouts.app')

@section('title', 'Verifikasi Pelanggan Baru')

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">📋 Verifikasi Pelanggan Baru</h2>
            <p class="text-muted">Daftar pelanggan yang menunggu verifikasi</p>
        </div>
        <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Data Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($pelanggans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Alamat</th>
                                <th>No. Meteran</th>
                                <th>Foto UTP</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pelanggans as $index => $pelanggan)
                                <tr>
                                    <td>{{ ($pelanggans->currentPage() - 1) * $pelanggans->perPage() + $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $pelanggan->nama_pelanggan }}</strong>
                                    </td>
                                    <td>{{ $pelanggan->user->email }}</td>
                                    <td>{{ $pelanggan->no_telepon ?? '-' }}</td>
                                    <td>{{ Str::limit($pelanggan->alamat, 50) }}</td>
                                    <td>
                                        <code>{{ $pelanggan->nomor_pelanggan }}</code>
                                    </td>
                                    <td>
                                        @if($pelanggan->foto_utp)
                                            <a href="{{ asset('storage/' . $pelanggan->foto_utp) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-image"></i> Lihat Foto
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>{{ $pelanggan->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#verifikasiModal{{ $pelanggan->id_pelanggan }}">
                                            <i class="fas fa-check"></i> Verifikasi
                                        </button>
                                    </td>
                                </tr>

                                <!-- Verification Modal -->
                                <div class="modal fade"
                                     id="verifikasiModal{{ $pelanggan->id_pelanggan }}"
                                     tabindex="-1"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-clipboard-check"></i>
                                                    Verifikasi Pelanggan: {{ $pelanggan->nama_pelanggan }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.pelanggan.verifikasi', $pelanggan) }}"
                                                  method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Keputusan Verifikasi</label>
                                                        <div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input"
                                                                       type="radio"
                                                                       name="status"
                                                                       id="approve{{ $pelanggan->id_pelanggan }}"
                                                                       value="1"
                                                                       checked>
                                                                <label class="form-check-label text-success" for="approve{{ $pelanggan->id_pelanggan }}">
                                                                    <i class="fas fa-check-circle"></i> Setujui
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input"
                                                                       type="radio"
                                                                       name="status"
                                                                       id="reject{{ $pelanggan->id_pelanggan }}"
                                                                       value="0">
                                                                <label class="form-check-label text-danger" for="reject{{ $pelanggan->id_pelanggan }}">
                                                                    <i class="fas fa-times-circle"></i> Tolak
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Catatan (Opsional)</label>
                                                        <textarea name="catatan"
                                                                  class="form-control"
                                                                  rows="3"
                                                                  placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan') }}</textarea>
                                                        <small class="text-muted">Catatan akan dikirim ke pelanggan via email/WhatsApp</small>
                                                    </div>

                                                    <div class="alert alert-info">
                                                        <small>
                                                            <strong>Data Pelanggan:</strong><br>
                                                            Email: {{ $pelanggan->user->email }}<br>
                                                            No. Telepon: {{ $pelanggan->no_telepon ?? 'Tidak ada' }}<br>
                                                            Alamat: {{ $pelanggan->alamat }}
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-check"></i> Konfirmasi Verifikasi
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $pelanggans->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h4>Tidak Ada Pelanggan Menunggu Verifikasi</h4>
                    <p class="text-muted">Semua pelanggan telah diverifikasi</p>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection
