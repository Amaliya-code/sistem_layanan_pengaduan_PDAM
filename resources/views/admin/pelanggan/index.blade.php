@extends('layouts.app')

@section('title','Kelola Pelanggan')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Data Pelanggan</h3>
        <div>
            <a href="{{ route('admin.pelanggan.belum-verifikasi') }}" class="btn btn-warning me-2">
                <i class="fas fa-clock"></i> Menunggu Verifikasi
                @php
                    $count = \App\Models\Pelanggan::whereHas('user', function($q) {
                        $q->where('status_verifikasi', false);
                    })->count();
                @endphp
                @if($count > 0)
                    <span class="badge bg-danger">{{ $count }}</span>
                @endif
            </a>
            <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-primary">Tambah Pelanggan</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nomor Pelanggan</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                            <th>Status Verifikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelanggans as $index => $p)
                        <tr>
                            <td>{{ ($pelanggans->currentPage() - 1) * $pelanggans->perPage() + $index + 1 }}</td>
                            <td><code>{{ $p->nomor_pelanggan }}</code></td>
                            <td><strong>{{ $p->nama_pelanggan }}</strong></td>
                            <td>{{ $p->user->email ?? 'Tidak ada user' }}</td>
                            <td>{{ Str::limit($p->alamat, 50) }}</td>
                            <td>{{ $p->no_telepon ?? '-' }}</td>
                            <td>
                                @if($p->user && $p->user->status_verifikasi)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> Terverifikasi
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock"></i> Menunggu
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.pelanggan.edit', $p) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.pelanggan.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pelanggan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $pelanggans->links() }}
        </div>
    </div>
</div>
@endsection
