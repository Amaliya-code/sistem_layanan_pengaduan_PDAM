@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="container">

    <div class="mb-4">
        <h3>👋 Halo, {{ auth()->user()->nama }}</h3>
        <p class="text-muted">Pantau status pengaduan Anda</p>
    </div>

    <div class="row g-3">

        <div class="col-md-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h4>{{ $total_pengaduan ?? 0 }}</h4>
                    <p>Total Pengaduan</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <h4>{{ $proses ?? 0 }}</h4>
                    <p>Sedang Diproses</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h4>{{ $selesai ?? 0 }}</h4>
                    <p>Selesai</p>
                </div>
            </div>
        </div>

    </div>

    <div class="card mt-4 shadow">
        <div class="card-header bg-dark text-white">
            📌 Riwayat Pengaduan
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($pengaduan as $p)
                    <tr>
                        <td>{{ $p->judul_pengaduan }}</td>
                        <td><span class="badge bg-info">{{ $p->status }}</span></td>
                        <td>{{ $p->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
