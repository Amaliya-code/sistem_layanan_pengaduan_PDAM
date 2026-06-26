@extends('layouts.app')

@section('title', 'Laporan Pengaduan - Admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Laporan Pengaduan</h3>
            <p class="text-muted">Rekapitulasi pengaduan berdasarkan periode.</p>
        </div>
        <a href="{{ route('admin.laporan.generate', ['periode' => date('Y-m')]) }}" class="btn btn-primary">Buat Laporan Bulan Ini</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.laporan.generate') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Periode</label>
                    <input type="month" name="periode" class="form-control" value="{{ request('periode', date('Y-m')) }}">
                </div>
                <div class="col-md-2 align-self-end">
                    <button type="submit" class="btn btn-success">Generate</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($laporans->count())
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Total</th>
                                <th>Menunggu</th>
                                <th>Diproses</th>
                                <th>Selesai</th>
                                <th>Dibuat Pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporans as $laporan)
                                <tr>
                                    <td>{{ $laporan->periode }}</td>
                                    <td>{{ $laporan->total_pengaduan }}</td>
                                    <td>{{ $laporan->menunggu }}</td>
                                    <td>{{ $laporan->diproses }}</td>
                                    <td>{{ $laporan->selesai }}</td>
                                    <td>{{ optional($laporan->created_at)->format('d M Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $laporans->links() }}
            @else
                <p class="text-muted mb-0">Belum ada laporan yang dibuat.</p>
            @endif
        </div>
    </div>
</div>
@endsection
