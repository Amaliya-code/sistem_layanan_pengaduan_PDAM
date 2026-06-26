@extends('layouts.app')

@section('title','Edit Pelanggan')

@section('content')
<div class="container py-4">
    <h3>Edit Pelanggan</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pelanggan.update', $pelanggan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">User (pilih akun)</label>
            <select name="id_user" class="form-select">
                <option value="">-- pilih user --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id_user }}" {{ $pelanggan->id_user == $u->id_user ? 'selected' : '' }}>{{ $u->nama }} ({{ $u->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor Pelanggan</label>
            <input type="text" name="nomor_pelanggan" class="form-control" value="{{ old('nomor_pelanggan', $pelanggan->nomor_pelanggan) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" class="form-control" value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control">{{ old('alamat', $pelanggan->alamat) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">No. Telepon</label>
            <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $pelanggan->no_telepon) }}">
        </div>

        <button class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
