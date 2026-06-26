@extends('layouts.app')

@section('title', $pengaduan->judul)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4>{{ $pengaduan->judul }}</h4>
                <span class="badge bg-{{ $pengaduan->status == 'selesai' ? 'success' : ($pengaduan->status == 'diproses' ? 'warning' : 'secondary') }}">
                    {{ ucfirst($pengaduan->status) }}
                </span>
            </div>
            <div class="card-body">
                <p>{!! nl2br(e($pengaduan->deskripsi)) !!}</p>
                @if($pengaduan->foto_bukti)
                    <img src="{{ asset('storage/' . $pengaduan->foto_bukti) }}" class="img-fluid rounded shadow" alt="Foto bukti">
                @endif
                <hr>
                <small class="text-muted">
                    <i class="fas fa-user"></i> {{ $pengaduan->user->name }}<br>
                    <i class="fas fa-clock"></i> {{ $pengaduan->created_at->format('d M Y H:i') }}<br>
                    <i class="fas fa-calendar-check"></i> {{ $pengaduan->updated_at->format('d M Y H:i') }}
                </small>
                <div class="mt-3">
                    <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    @if(auth()->user()->isPelanggan() && auth()->user()->pelanggan->id_pelanggan === $pengaduan->id_pelanggan)
                        <a href="{{ route('pengaduan.edit', $pengaduan) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('pengaduan.destroy', $pengaduan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

