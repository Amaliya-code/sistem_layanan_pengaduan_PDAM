@extends('layouts.app')

@section('title', 'Tambah Petugas')

@section('content')
<div class="container">
    <h2>Tambah Petugas</h2>

    <form action="{{ route('admin.petugas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Petugas</label>
            <input type="text" name="nama_petugas" class="form-control">
        </div>

        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control">
        </div>

        <div class="mb-3">
            <label>No Telepon</label>
            <input type="text" name="no_telepon" class="form-control">
        </div>

        <button class="btn btn-success">
            Simpan
        </button>
    </form>
</div>
@endsection
