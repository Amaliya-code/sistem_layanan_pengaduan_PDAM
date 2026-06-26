<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Menampilkan form registrasi.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Menyimpan data registrasi user baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'nomor_pelanggan' => ['required', 'string', 'max:30', 'unique:pelanggan,nomor_pelanggan'],
            'alamat' => ['required', 'string'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],
        ]);

        $user = User::create([
            'nama'      => $validated['nama'],
            'email'     => $validated['email'],
            'whatsapp'  => $validated['whatsapp'] ?? null,
            'password'  => Hash::make($validated['password']),
            'role'      => 'pelanggan',
        ]);

        Pelanggan::create([
            'id_user' => $user->id_user,
            'nomor_pelanggan' => $validated['nomor_pelanggan'],
            'nama_pelanggan' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'no_telepon' => $validated['no_telepon'] ?? null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()
            ->route('pengaduan.index')
            ->with('success', 'Registrasi berhasil!');
    }
}
