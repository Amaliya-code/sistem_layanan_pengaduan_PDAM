
@extends('layouts.app')

@section('title', 'Daftar Pengaduan')

@section('content')
<h2>
    @if(auth()->user()->isAdmin())
        <i class="fas fa-list"></i> Semua Pengaduan
    @else
        <i class="fas fa-list"></i> Pengaduan Saya
    @endif
</h2>

<a href="{{ url('/pengaduan/create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Buat Pengaduan Baru
</a>

@if($pengaduans->count() > 0)
    @foreach($pengaduans as $p)
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between">
            <span class="h5 m-0">{{ $p->judul_pengaduan }}</span>
            <span class="badge bg-{{ $p->status == 'selesai' ? 'success' : ($p->status == 'diproses' ? 'warning' : 'secondary') }}">
                {{ ucfirst($p->status) }}
            </span>
        </div>
        <div class="card-body">
            <p>{{ $p->deskripsi }}</p>
            @if($p->foto_bukti)
                <img src="{{ asset('storage/' . $p->foto_bukti) }}" class="img-thumbnail" style="max-width: 300px;">
            @endif
            @if(auth()->user()->isAdmin() && $p->user)
                <small class="text-muted">Oleh: {{ $p->user->name }}</small>
            @endif
            <small class="text-muted">{{ $p->created_at->diffForHumans() }}</small>
        </div>
    </div>
    @endforeach
@else
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> Belum ada pengaduan.
    </div>
@endif

{{ $pengaduans->links() }}
@endsection
