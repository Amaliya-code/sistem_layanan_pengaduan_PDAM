@extends('layouts.app')

@section('title', 'Edit Petugas')

@section('content')
<div class="container">
    <h2>Edit Petugas</h2>

    <form action="{{ route('admin.petugas.update',$petugas->id_petugas) }}"
          method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Petugas</label>
            <input type="text"
                   name="nama_petugas"
                   class="form-control"
                   value="{{ $petugas->nama_petugas }}">
        </div>

        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text"
                   name="jabatan"
                   class="form-control"
                   value="{{ $petugas->jabatan }}">
        </div>

        <div class="mb-3">
            <label>No Telepon</label>
            <input type="text"
                   name="no_telepon"
                   class="form-control"
                   value="{{ $petugas->no_telepon }}">
        </div>

        <button class="btn btn-primary">
            Update
        </button>
    </form>
</div>
@endsection
