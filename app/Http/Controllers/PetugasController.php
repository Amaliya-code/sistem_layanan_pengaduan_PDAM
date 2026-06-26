<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\TrackingPengaduan;
use App\Models\Pengaduan;
use App\Models\Notifikasi;
use App\Services\WhatsappService;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $petugas = $user->petugas;

        $pengaduans = TrackingPengaduan::where('id_petugas', $petugas->id_petugas)
            ->whereHas('pengaduan', function ($q) {
                $q->where('status', 'diproses');
            })
            ->with('pengaduan.pelanggan.user')
            ->latest('tanggal_update')
            ->get();

        $menunggu = Pengaduan::where('status', 'menunggu')->count();
        $diproses = Pengaduan::where('status', 'diproses')->count();
        $selesai = Pengaduan::where('status', 'selesai')->count();

        return view('petugas.dashboard', compact('pengaduans', 'menunggu', 'diproses', 'selesai'));
    }

    public function updateStatus(Request $request, TrackingPengaduan $tracking)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'keterangan' => 'required|string'
        ]);

        // Update pengaduan status
        $tracking->pengaduan->update(['status' => $validated['status']]);

        // Create new tracking record instead of updating existing
        TrackingPengaduan::create([
            'id_pengaduan' => $tracking->id_pengaduan,
            'id_petugas' => $tracking->id_petugas,
            'status' => $validated['status'],
            'keterangan' => $validated['keterangan'],
            'tanggal_update' => now(),
        ]);

        // Send notification to pelanggan
        $pelanggan = $tracking->pengaduan->pelanggan;

        if ($pelanggan && $pelanggan->user) {
            // Email notification
            Notifikasi::create([
                'id_pengaduan' => $tracking->id_pengaduan,
                'penerima' => $pelanggan->user->email,
                'jenis_notifikasi' => 'email',
                'pesan' => "Status pengaduan {$tracking->pengaduan->nomor_pengaduan} berubah menjadi: {$validated['status']}",
                'tanggal_kirim' => now(),
            ]);

            // WhatsApp notification
            if ($pelanggan->user->whatsapp) {
                try {
                    WhatsappService::send(
                        $pelanggan->user->whatsapp,
                        "📢 UPDATE PENGADUAN\n\n" .
                        "No: {$tracking->pengaduan->nomor_pengaduan}\n" .
                        "Status: {$validated['status']}\n" .
                        "Keterangan: {$validated['keterangan']}\n\n" .
                        "Silakan cek detail pengaduan Anda di sistem."
                    );
                } catch (\Exception $e) {
                    Log::error('Gagal kirim WA update status: ' . $e->getMessage());
                }
            }
        }

        return back()->with('success', 'Status berhasil diupdate');
    }
}
