<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Pelanggan;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Check if user is verified (for pelanggan)
            if ($user->isPelanggan() && !$user->status_verifikasi) {
                Auth::logout();
                return back()->with('error', 'Akun Anda belum diverifikasi oleh admin. Silakan tunggu atau hubungi admin.');
            }

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            if ($user->isPetugas()) {
                return redirect()->route('petugas.dashboard');
            }

            return redirect()->route('pengaduan.index');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'nomor_meteran' => 'required|string|max:50|unique:pelanggan',
            'foto_utp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'whatsapp' => 'nullable|string|max:20'
        ]);

        // Create user with pending verification
        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pelanggan',
            'whatsapp' => $validated['whatsapp'],
            'status_verifikasi' => false
        ]);

        // Handle UTP photo upload
        $fotoUtpPath = null;
        if ($request->hasFile('foto_utp')) {
            $fotoUtpPath = $request->file('foto_utp')->store('utp', 'public');
        }

        // Create pelanggan record
        $user->pelanggan()->create([
            'nomor_pelanggan' => $validated['nomor_meteran'],
            'nama_pelanggan' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'no_telepon' => $validated['no_telepon'],
            'foto_utp' => $fotoUtpPath
        ]);

        // Notify admins about new registration
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            if ($admin->whatsapp) {
                try {
                    \App\Services\WhatsappService::send(
                        $admin->whatsapp,
                        "📋 PENDAFTARAN PELANGGAN BARU\n\n" .
                        "Nama: {$validated['nama']}\n" .
                        "Email: {$validated['email']}\n" .
                        "No. Meteran: {$validated['nomor_meteran']}\n\n" .
                        "Silakan verifikasi data pelanggan baru di dashboard admin."
                    );
                } catch (\Exception $e) {
                    \Log::error('Gagal kirim WA notifikasi registrasi: ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun Anda akan diverifikasi oleh admin. Silakan login kembali setelah diverifikasi.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

