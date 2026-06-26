@extends('layouts.app')

@section('title', 'Laporan Pengaduan')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-body">
            <h3>Laporan Pengaduan Periode {{ $laporan->periode }}</h3>
            <div class="mb-3">
                <p>Total Pengaduan: <strong>{{ $laporan->total_pengaduan }}</strong></p>
                <p>Menunggu: <strong>{{ $laporan->menunggu }}</strong></p>
                <p>Diproses: <strong>{{ $laporan->diproses }}</strong></p>
                <p>Selesai: <strong>{{ $laporan->selesai }}</strong></p>
            </div>
            <a href="{{ route('admin.laporan') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
