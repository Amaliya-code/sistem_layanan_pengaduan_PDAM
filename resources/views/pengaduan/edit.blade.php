@extends('layouts.app')

@section('title', 'Edit ' . $pengaduan->judul)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-edit"></i> Edit Pengaduan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('pengaduan.update', $pengaduan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Jenis Pengaduan</label>
                        <select name="jenis_pengaduan" class="form-control @error('jenis_pengaduan') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Pipa Bocor" {{ old('jenis_pengaduan', $pengaduan->jenis_pengaduan) == 'Pipa Bocor' ? 'selected' : '' }}>Pipa Bocor</option>
                            <option value="Air Keruh" {{ old('jenis_pengaduan', $pengaduan->jenis_pengaduan) == 'Air Keruh' ? 'selected' : '' }}>Air Keruh</option>
                            <option value="Meteran Error" {{ old('jenis_pengaduan', $pengaduan->jenis_pengaduan) == 'Meteran Error' ? 'selected' : '' }}>Meteran Error</option>
                            <option value="Tagihan Salah" {{ old('jenis_pengaduan', $pengaduan->jenis_pengaduan) == 'Tagihan Salah' ? 'selected' : '' }}>Tagihan Salah</option>
                            <option value="Lainnya" {{ old('jenis_pengaduan', $pengaduan->jenis_pengaduan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis_pengaduan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Judul Pengaduan</label>
                        <input type="text" class="form-control @error('judul_pengaduan') is-invalid @enderror" name="judul_pengaduan" value="{{ old('judul_pengaduan', $pengaduan->judul_pengaduan) }}" required>
                        @error('judul_pengaduan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="5" required>{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" value="{{ old('lokasi', $pengaduan->lokasi) }}" required>
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto Bukti Baru (Opsional, lama tetap ada)</label>
                        <input type="file" class="form-control @error('foto_bukti') is-invalid @enderror" name="foto_bukti" accept="image/*">
                        @if($pengaduan->foto_bukti)
                            <img src="{{ asset('storage/' . $pengaduan->foto_bukti) }}" class="img-thumbnail mt-2" style="max-width: 200px;">
                        @endif
                        @error('foto_bukti')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('pengaduan.show', $pengaduan) }}" class="btn btn-secondary me-md-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Update Pengaduan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

