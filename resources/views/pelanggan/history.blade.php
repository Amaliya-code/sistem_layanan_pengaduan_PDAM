@extends('layouts.app')

@section('title', 'Riwayat Pengaduan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-history"></i> Riwayat Pengaduan Saya</h2>
    <a href="{{ url('/pengaduan/create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Pengaduan Baru
    </a>
</div>

@if($pengaduan->count() > 0)
    @foreach($pengaduan as $p)
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h5 class="card-title">{{ $p->judul }}</h5>
                <span class="badge bg-{{ $p->status == 'selesai' ? 'success' : ($p->status == 'diproses' ? 'warning' : 'secondary') }}">{{ ucfirst($p->status) }}</span>
            </div>
            <p class="card-text">{{ $p->deskripsi }}</p>
            @if($p->foto_bukti)
                <img src="{{ asset('storage/' . $p->foto_bukti) }}" class="img-thumbnail" style="max-width: 200px;">
            @endif
            <p class="text-muted small">{{ $p->created_at->format('d M Y H:i') }}</p>
        </div>
    </div>
    @endforeach
@else
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle fa-2x mb-3 d-block"></i>
        Belum ada riwayat pengaduan.
    </div>
@endif
@endsection

