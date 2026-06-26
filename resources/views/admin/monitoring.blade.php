@extends('layouts.app')

@section('title', 'Monitoring - Admin')

@section('content')
<div class="container">
    <h3>Monitoring Sistem</h3>
    <p class="text-muted">Ringkasan aktivitas terbaru (placeholder)</p>

    <div class="card mt-3">
        <div class="card-body">
            <h5>Pengaduan Terbaru</h5>
            <ul>
                @foreach($recent_pengaduan as $p)
                <li>{{ $p->nomor_pengaduan }} — {{ $p->judul_pengaduan }} ({{ $p->status }})</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
