<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Pengaduan;
use App\Models\Pelanggan;
use App\Models\TrackingPengaduan;
use App\Models\Notifikasi;
use App\Models\User;
use App\Services\WhatsappService;

class PengaduanController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            $pengaduans = Pengaduan::with('pelanggan')
                ->latest('tanggal_pengaduan')
                ->paginate(10);

        } elseif ($user->isPelanggan()) {
            $pelanggan = $user->pelanggan;

            $pengaduans = $pelanggan->pengaduans()
                ->latest('tanggal_pengaduan')
                ->paginate(10);

            // Get stats for dashboard
            $stats = [
                'total' => $pengaduans->total(),
                'menunggu' => $pelanggan->pengaduans()->where('status', 'menunggu')->count(),
                'diproses' => $pelanggan->pengaduans()->where('status', 'diproses')->count(),
                'selesai' => $pelanggan->pengaduans()->where('status', 'selesai')->count(),
            ];

            return view('dashboard', compact('pengaduans', 'stats'));

        } else {
            abort(403);
        }

        return view('pengaduan.index', compact('pengaduans'));
    }

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isPelanggan()) {
            abort(403, 'Hanya pelanggan dapat membuat pengaduan');
        }

        return view('pengaduan.create');
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'jenis_pengaduan' => 'required|string|max:100',
            'judul_pengaduan' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $pelanggan = $user->pelanggan;

        if (!$pelanggan) {
            return back()->with('error', 'Data pelanggan tidak ditemukan');
        }

        $nomor = Pengaduan::generateNomorPengaduan();
        $fotoPath = null;

        if ($request->hasFile('foto_bukti')) {
            $fotoPath = $request->file('foto_bukti')->store('pengaduan', 'public');
        }

        $pengaduan = Pengaduan::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'nomor_pengaduan' => $nomor,
            'jenis_pengaduan' => $validated['jenis_pengaduan'],
            'judul_pengaduan' => $validated['judul_pengaduan'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi' => $validated['lokasi'],
            'foto_bukti' => $fotoPath,
            'status' => 'menunggu',
            'tanggal_pengaduan' => now(),
        ]);

        TrackingPengaduan::create([
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'status' => 'menunggu',
            'keterangan' => 'Pengaduan baru masuk',
            'tanggal_update' => now(),
        ]);

        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notifikasi::create([
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'penerima' => $admin->email,
                'jenis_notifikasi' => 'email',
                'pesan' => "Pengaduan baru: {$pengaduan->judul_pengaduan}",
                'tanggal_kirim' => now(),
            ]);

            if ($admin->whatsapp) {
                try {
                    WhatsappService::send(
                        $admin->whatsapp,
                        "📢 PENGADUAN BARU\n\n" .
                        "No: {$pengaduan->nomor_pengaduan}\n" .
                        "Judul: {$pengaduan->judul_pengaduan}\n" .
                        "Pelanggan: {$pelanggan->nama_pelanggan}\n" .
                        "Status: Menunggu Verifikasi"
                    );
                } catch (\Exception $e) {
                    Log::error('Gagal kirim WA: ' . $e->getMessage());
                }
            }
        }

        return redirect()
            ->route('pengaduan.show', $pengaduan)
            ->with('success', "Pengaduan berhasil dibuat! Nomor: {$nomor}");
    }

    public function show(Pengaduan $pengaduan)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isPelanggan() &&
            $user->pelanggan->id_pelanggan !== $pengaduan->id_pelanggan) {
            abort(403);
        }

        $tracking = $pengaduan->trackingPengaduans()
            ->orderBy('tanggal_update', 'desc')
            ->get();

        return view('pengaduan.show', compact('pengaduan', 'tracking'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        $user = Auth::user();

        if ($user->isPelanggan() &&
            $user->pelanggan->id_pelanggan !== $pengaduan->id_pelanggan) {
            abort(403);
        }

        $validated = $request->validate([
            'jenis_pengaduan' => 'required|string|max:100',
            'judul_pengaduan' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('foto_bukti')) {
            if ($pengaduan->foto_bukti) {
                Storage::disk('public')->delete($pengaduan->foto_bukti);
            }

            $validated['foto_bukti'] = $request->file('foto_bukti')->store('pengaduan', 'public');
        }

        $pengaduan->update([
            'jenis_pengaduan' => $validated['jenis_pengaduan'],
            'judul_pengaduan' => $validated['judul_pengaduan'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi' => $validated['lokasi'],
            'foto_bukti' => $validated['foto_bukti'] ?? $pengaduan->foto_bukti,
        ]);

        return redirect()->route('pengaduan.show', $pengaduan)
            ->with('success', 'Pengaduan berhasil diperbarui');
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isAdmin() && !$user->isPetugas()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'keterangan' => 'required|string'
        ]);

        $pengaduan->update([
            'status' => $validated['status'],
        ]);

        TrackingPengaduan::create([
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'id_petugas' => $user->isPetugas() ? $user->petugas->id_petugas : null,
            'status' => $validated['status'],
            'keterangan' => $validated['keterangan'],
            'tanggal_update' => now(),
        ]);

        $pelanggan = $pengaduan->pelanggan;

        Notifikasi::create([
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'penerima' => $pelanggan->user->email,
            'jenis_notifikasi' => 'email',
            'pesan' => "Status pengaduan {$pengaduan->nomor_pengaduan} berubah menjadi: {$validated['status']}",
            'tanggal_kirim' => now(),
        ]);

        return back()->with('success', 'Status berhasil diupdate');
    }

    public function destroy(Pengaduan $pengaduan)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isPelanggan() &&
            $user->pelanggan->id_pelanggan !== $pengaduan->id_pelanggan) {
            abort(403);
        }

        if ($pengaduan->foto_bukti) {
            Storage::disk('public')->delete($pengaduan->foto_bukti);
        }

        $pengaduan->delete();

        return redirect()
            ->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus');
    }
}
