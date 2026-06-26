@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-6">Buat Pengaduan Baru</h2>

                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Jenis Pengaduan</label>
                        <select name="jenis_pengaduan" class="w-full border rounded px-3 py-2" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Pipa Bocor">Pipa Bocor</option>
                            <option value="Air Keruh">Air Keruh</option>
                            <option value="Meteran Error">Meteran Error</option>
                            <option value="Tagihan Salah">Tagihan Salah</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        @error('jenis_pengaduan')<span class="text-red-500">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Judul Pengaduan</label>
                        <input type="text" name="judul_pengaduan" class="w-full border rounded px-3 py-2" required>
                        @error('judul_pengaduan')<span class="text-red-500">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="5" class="w-full border rounded px-3 py-2" required></textarea>
                        @error('deskripsi')<span class="text-red-500">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Lokasi</label>
                        <input type="text" name="lokasi" class="w-full border rounded px-3 py-2" required>
                        @error('lokasi')<span class="text-red-500">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Foto Bukti</label>
                        <input type="file" name="foto_bukti" accept="image/*" class="w-full border rounded px-3 py-2">
                        @error('foto_bukti')<span class="text-red-500">{{ $message }}</span>@enderror
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Kirim Pengaduan
                        </button>
                        <a href="{{ route('pengaduan.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
