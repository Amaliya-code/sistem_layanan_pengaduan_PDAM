@extends('layouts.app')

@section('title', 'Buat Pengaduan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="fas fa-exclamation-triangle"></i>
                    Laporkan Gangguan PDAM
                </h4>
            </div>

            <div class="card-body">

                <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">
                            Jenis Pengaduan
                            <span class="text-danger">*</span>
                        </label>

                        <select name="jenis_pengaduan" class="form-control @error('jenis_pengaduan') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Pipa Bocor" {{ old('jenis_pengaduan') == 'Pipa Bocor' ? 'selected' : '' }}>Pipa Bocor</option>
                            <option value="Air Keruh" {{ old('jenis_pengaduan') == 'Air Keruh' ? 'selected' : '' }}>Air Keruh</option>
                            <option value="Meteran Error" {{ old('jenis_pengaduan') == 'Meteran Error' ? 'selected' : '' }}>Meteran Error</option>
                            <option value="Tagihan Salah" {{ old('jenis_pengaduan') == 'Tagihan Salah' ? 'selected' : '' }}>Tagihan Salah</option>
                            <option value="Lainnya" {{ old('jenis_pengaduan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>

                        @error('jenis_pengaduan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Judul Pengaduan
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            class="form-control @error('judul_pengaduan') is-invalid @enderror"
                            name="judul_pengaduan"
                            value="{{ old('judul_pengaduan') }}"
                            required>

                        @error('judul_pengaduan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Deskripsi Gangguan
                            <span class="text-danger">*</span>
                        </label>

                        <textarea
                            class="form-control @error('deskripsi') is-invalid @enderror"
                            name="deskripsi"
                            rows="5"
                            required>{{ old('deskripsi') }}</textarea>

                        @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Lokasi
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            name="lokasi"
                            class="form-control @error('lokasi') is-invalid @enderror"
                            value="{{ old('lokasi') }}"
                            required>

                        @error('lokasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Foto Bukti (Opsional)
                        </label>

                        <input type="file"
                            class="form-control @error('foto_bukti') is-invalid @enderror"
                            name="foto_bukti"
                            accept="image/*">

                        @error('foto_bukti')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">

                        <a href="{{ url()->previous() }}"
                            class="btn btn-secondary me-md-2">

                            Batal
                        </a>

                        <button type="submit"
                            class="btn btn-primary">

                            Kirim Laporan
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
function getLocation() {

    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(function(position) {

            document.getElementById("latitude").value =
                position.coords.latitude;

            document.getElementById("longitude").value =
                position.coords.longitude;

        });

    } else {

        alert("Geolocation tidak didukung browser.");

    }
}
</script>

@endsection
