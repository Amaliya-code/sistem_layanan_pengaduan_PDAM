@extends('layouts.app')

@section('title', 'Kelola Pengaduan')

@section('content')

<h2>
    <i class="fas fa-exclamation-triangle"></i>
    Kelola Pengaduan
</h2>

<div class="table-responsive">

    <table class="table table-striped">

        <thead>
            <tr>
                <th>ID</th>
                <th>Pelapor</th>
                <th>Judul</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse($pengaduans as $p)

            <tr>

                <td>
                    {{ $p->id_pengaduan }}
                </td>

                <td>
                    {{ $p->user->name }}

                    <br>

                    <small>
                        {{ $p->user->email }}
                    </small>
                </td>

                <td>
                    {{ Str::limit($p->judul_pengaduan, 50) }}
                </td>

                <td>

                    @if($p->lokasi)

                        <small class="text-muted">
                            {{ $p->lokasi }}
                        </small>

                    @else

                        <span class="text-muted">
                            Lokasi tidak tersedia
                        </span>

                    @endif

                </td>

                <td>

                    <span class="badge bg-{{
                        $p->status == 'selesai'
                        ? 'success'
                        : ($p->status == 'diproses'
                            ? 'warning'
                            : 'secondary')
                    }}">

                        {{ ucfirst($p->status) }}

                    </span>

                </td>

                <td>
                    {{ $p->created_at->format('d M Y H:i') }}
                </td>

                <td>

                    {{-- FORM UPDATE STATUS --}}
                    <form
                        method="POST"
                        action="{{ route('admin.pengaduan.updateStatus', $p) }}"
                        class="d-inline"
                    >

                        @csrf
                        @method('PUT')

                        <select
                            name="status"
                            class="form-select form-select-sm d-inline w-auto"
                            onchange="this.form.submit()"
                        >

                            <option
                                value="menunggu"
                                {{ $p->status == 'menunggu' ? 'selected' : '' }}
                            >
                                Menunggu
                            </option>

                            <option
                                value="diproses"
                                {{ $p->status == 'diproses' ? 'selected' : '' }}
                            >
                                Diproses
                            </option>

                            <option
                                value="selesai"
                                {{ $p->status == 'selesai' ? 'selected' : '' }}
                            >
                                Selesai
                            </option>

                            <option
                                value="ditolak"
                                {{ $p->status == 'ditolak' ? 'selected' : '' }}
                            >
                                Ditolak
                            </option>

                        </select>

                    </form>

                    {{-- TOMBOL FOTO --}}
                    @if($p->foto_bukti)

                        <a
                            href="{{ asset('storage/' . $p->foto_bukti) }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-info"
                        >
                            <i class="fas fa-image"></i>
                        </a>

                    @endif

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="7" class="text-center">

                    Belum ada pengaduan.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

{{-- PAGINATION --}}
{{ $pengaduans->links() }}

@endsection
