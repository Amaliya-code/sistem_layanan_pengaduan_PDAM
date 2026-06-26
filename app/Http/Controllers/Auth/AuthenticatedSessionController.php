<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validasi login
        $request->authenticate();

        // Regenerate session (WAJIB untuk keamanan)
        $request->session()->regenerate();

        // FIX PENTING: ambil user dari request, bukan Auth::user()
        $user = $request->user();

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'petugas') {
            return redirect()->route('petugas.dashboard');
        }

        if ($user->role === 'pelanggan') {
            return redirect()->route('pengaduan.index');
        }

        // fallback kalau role tidak dikenali
        return redirect()->route('dashboard');
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
