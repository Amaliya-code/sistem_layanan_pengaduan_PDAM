@extends('layouts.app')

@section('title', 'Notifikasi - Admin')

@section('content')
<div class="container">
    <h3>Notifikasi</h3>

    <div class="card mt-3">
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Penerima</th>
                        <th>Jenis</th>
                        <th>Pesan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifikasis as $n)
                    <tr>
                        <td>{{ $n->penerima }}</td>
                        <td>{{ $n->jenis_notifikasi }}</td>
                        <td>{{ $n->pesan }}</td>
                        <td>{{ $n->tanggal_kirim->format('d M Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $notifikasis->links() }}
        </div>
    </div>
</div>
@endsection
