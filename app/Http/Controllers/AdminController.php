<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Pengaduan;
use App\Models\Pelanggan;
use App\Models\Petugas;
use App\Models\LaporanPengaduan;
use App\Models\TrackingPengaduan;
use App\Models\Notifikasi;
use App\Models\User;

class AdminController extends Controller
{
    // ================= DASHBOARD =================
    public function dashboard()
    {
        $stats = [
            'total_pelanggan' => Pelanggan::count(),
            'total_pengaduan' => Pengaduan::count(),
            'menunggu' => Pengaduan::where('status', 'menunggu')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
        ];

        $pengaduan_terbaru = Pengaduan::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'pengaduan_terbaru'));
    }

    // ================= PENGADUAN =================
    public function pengaduanIndex()
    {
        $pengaduans = Pengaduan::latest()->paginate(15);

        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    public function pengaduanShow(int $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function assignPetugas(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'id_petugas' => 'required|exists:petugas,id_petugas'
        ]);

        $pengaduan->update([
            'status' => 'diproses'
        ]);

        TrackingPengaduan::create([
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'id_petugas' => $request->id_petugas,
            'status' => 'diproses',
            'keterangan' => 'Petugas ditugaskan',
            'tanggal_update' => now(),
        ]);

        return back()->with('success', 'Petugas berhasil ditugaskan');
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak'
        ]);

        $pengaduan->update([
            'status' => $validated['status']
        ]);

        TrackingPengaduan::create([
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'status' => $validated['status'],
            'keterangan' => 'Status diubah oleh admin',
            'tanggal_update' => now(),
        ]);

        // CEGAH ERROR RELASI NULL
        if ($pengaduan->pelanggan && $pengaduan->pelanggan->user) {
            Notifikasi::create([
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'penerima' => $pengaduan->pelanggan->user->email,
                'jenis_notifikasi' => 'email',
                'pesan' => "Status pengaduan {$pengaduan->nomor_pengaduan} berubah menjadi: {$validated['status']}",
                'tanggal_kirim' => now(),
            ]);
        }

        return back()->with('success', 'Status pengaduan berhasil diperbarui');
    }

    // ================= PELANGGAN =================
    public function pelangganIndex()
    {
        $pelanggans = Pelanggan::with('user')->paginate(15);

        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    public function pelangganBelumVerifikasi()
    {
        $pelanggans = Pelanggan::whereHas('user', function ($q) {
            $q->where('status_verifikasi', false);
        })->with('user')->paginate(15);

        return view('admin.pelanggan.belum-verifikasi', compact('pelanggans'));
    }

    public function verifikasiPelanggan(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'status' => 'required|in:1,0', // 1 = approve, 0 = reject
            'catatan' => 'nullable|string|max:500'
        ]);

        $user = $pelanggan->user;
        $user->update([
            'status_verifikasi' => (bool) $request->status
        ]);

        // Send notification to pelanggan
        $statusText = $request->status == 1 ? 'disetujui' : 'ditolak';
        $pesan = "Pendaftaran Anda telah {$statusText}.";

        if ($request->catatan) {
            $pesan .= "\n\nCatatan: {$request->catatan}";
        }

        Notifikasi::create([
            'id_pengaduan' => null,
            'penerima' => $user->email,
            'jenis_notifikasi' => 'email',
            'pesan' => $pesan,
            'tanggal_kirim' => now(),
        ]);

        // Send WhatsApp notification if available
        if ($user->whatsapp) {
            try {
                \App\Services\WhatsappService::send(
                    $user->whatsapp,
                    "✅ VERIFIKASI PENDAFTARAN\n\n" .
                    "Halo {$pelanggan->nama_pelanggan},\n\n" .
                    "Pendaftaran Anda sebagai pelanggan PDAM Tirta Albantani telah {$statusText}.\n\n" .
                    ($request->catatan ? "Catatan: {$request->catatan}\n\n" : "") .
                    "Silakan login untuk menggunakan layanan pengaduan."
                );
            } catch (\Exception $e) {
                \Log::error('Gagal kirim WA verifikasi: ' . $e->getMessage());
            }
        }

        return back()->with('success', "Pelanggan berhasil {$statusText}");
    }

    public function pelangganCreate()
    {
        $users = User::where('role', 'pelanggan')
            ->whereDoesntHave('pelanggan')
            ->get();

        return view('admin.pelanggan.create', compact('users'));
    }

    public function pelangganStore(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'nomor_pelanggan' => 'required|unique:pelanggan,nomor_pelanggan',
            'nama_pelanggan' => 'required|string|max:150',
            'alamat' => 'required',
            'no_telepon' => 'nullable|string',
        ]);

        Pelanggan::create($validated);

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil dibuat');
    }

    public function pelangganEdit(Pelanggan $pelanggan)
    {
        $users = User::where('role', 'pelanggan')->get();

        return view('admin.pelanggan.edit', compact('pelanggan', 'users'));
    }

    public function pelangganUpdate(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'nomor_pelanggan' => 'required|unique:pelanggan,nomor_pelanggan,' . $pelanggan->id_pelanggan . ',id_pelanggan',
            'nama_pelanggan' => 'required|string|max:150',
            'alamat' => 'required',
            'no_telepon' => 'nullable|string',
        ]);

        $pelanggan->update($validated);

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil diperbarui');
    }

    public function pelangganDestroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return back()->with('success', 'Pelanggan dihapus');
    }

    // ================= PETUGAS =================
    public function petugasIndex()
    {
        $petugas = Petugas::latest()->paginate(10);

        return view('admin.petugas.index', compact('petugas'));
    }

    public function editPetugas(Petugas $petugas)
    {
        return view('admin.petugas.edit', compact('petugas'));
    }

    public function updatePetugas(Request $request, Petugas $petugas)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'jabatan' => 'required|string|max:100',
            'no_telepon' => 'nullable|string',
        ]);

        $petugas->update($validated);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil diperbarui');
    }

    // ================= LAPORAN =================
    public function laporan()
    {
        $laporans = LaporanPengaduan::latest()->paginate(10);

        return view('admin.laporan', compact('laporans'));
    }

    public function generateLaporan(Request $request)
    {
        $periode = $request->input('periode', date('Y-m'));

        $tahun = substr($periode, 0, 4);
        $bulan = substr($periode, 5, 2);

        $total = Pengaduan::whereYear('created_at', $tahun)->whereMonth('created_at', $bulan)->count();
        $menunggu = Pengaduan::whereYear('created_at', $tahun)->whereMonth('created_at', $bulan)->where('status', 'menunggu')->count();
        $diproses = Pengaduan::whereYear('created_at', $tahun)->whereMonth('created_at', $bulan)->where('status', 'diproses')->count();
        $selesai = Pengaduan::whereYear('created_at', $tahun)->whereMonth('created_at', $bulan)->where('status', 'selesai')->count();

        $laporan = LaporanPengaduan::updateOrCreate(
            ['periode' => $periode],
            [
                'total_pengaduan' => $total,
                'menunggu' => $menunggu,
                'diproses' => $diproses,
                'selesai' => $selesai,
            ]
        );

        return view('admin.laporan-pdf', compact('laporan'));
    }

    // ================= NOTIFIKASI =================
    public function notifikasiIndex()
    {
        $notifikasis = Notifikasi::latest()->paginate(20);

        return view('admin.notifikasi.index', compact('notifikasis'));
    }

    // ================= MONITORING =================
    public function monitoring()
    {
        $recent_pengaduan = Pengaduan::latest()->take(10)->get();

        return view('admin.monitoring', compact('recent_pengaduan'));
    }
}
