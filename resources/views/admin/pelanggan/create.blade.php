@extends('layouts.app')

@section('title','Tambah Pelanggan')

@section('content')
<div class="container py-4">
    <h3>Tambah Pelanggan</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pelanggan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">User (pilih akun)</label>
            <select name="id_user" class="form-select">
                <option value="">-- pilih user --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id_user }}">{{ $u->nama }} ({{ $u->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor Pelanggan</label>
            <input type="text" name="nomor_pelanggan" class="form-control" value="{{ old('nomor_pelanggan') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" class="form-control" value="{{ old('nama_pelanggan') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control">{{ old('alamat') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">No. Telepon</label>
            <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon') }}">
        </div>

        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
