@extends('layouts.app')

@section('title', 'Data Petugas')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h2>Data Petugas</h2>
        <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary">
            Tambah Petugas
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Petugas</th>
                <th>Jabatan</th>
                <th>No Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($petugas as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_petugas }}</td>
                <td>{{ $item->jabatan }}</td>
                <td>{{ $item->no_telepon }}</td>
                <td>
                    <a href="{{ route('admin.petugas.edit',$item->id_petugas) }}"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">
                    Data petugas belum tersedia
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
