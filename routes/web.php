<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
});

Route::get('/help', function () {
    return view('help');
})->name('help');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (BREEZE)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| PROFILE (ALL USER)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| PELANGGAN (DEFAULT USER)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'pelanggan'])->group(function () {

    Route::resource('pengaduan', PengaduanController::class);

    Route::put('pengaduan/{pengaduan}/status', [PengaduanController::class, 'updateStatus'])
        ->name('pengaduan.updateStatus');
});

/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'petugas'])->prefix('petugas')->group(function () {

    Route::get('/dashboard', [PetugasController::class, 'dashboard'])
        ->name('petugas.dashboard');

    Route::put('/tracking/{tracking}/status', [PetugasController::class, 'updateStatus'])
        ->name('tracking.updateStatus');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*//*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | PENGADUAN
    |--------------------------------------------------------------------------
    */
    Route::get('/pengaduan', [AdminController::class, 'pengaduanIndex'])
        ->name('admin.pengaduan.index');

    Route::get('/pengaduan/{pengaduan}', [AdminController::class, 'pengaduanShow'])
        ->name('admin.pengaduan.show');

    Route::post('/pengaduan/{pengaduan}/assign', [AdminController::class, 'assignPetugas'])
        ->name('admin.pengaduan.assign');

    Route::put('/pengaduan/{pengaduan}/status', [AdminController::class, 'updateStatus'])
        ->name('admin.pengaduan.updateStatus');

    /*
    |--------------------------------------------------------------------------
    | PELANGGAN
    |--------------------------------------------------------------------------
    */
    Route::get('/pelanggan', [AdminController::class, 'pelangganIndex'])
        ->name('admin.pelanggan.index');

    Route::get('/pelanggan/belum-verifikasi', [AdminController::class, 'pelangganBelumVerifikasi'])
        ->name('admin.pelanggan.belum-verifikasi');

    Route::post('/pelanggan/{pelanggan}/verifikasi', [AdminController::class, 'verifikasiPelanggan'])
        ->name('admin.pelanggan.verifikasi');

    Route::get('/pelanggan/create', [AdminController::class, 'pelangganCreate'])
        ->name('admin.pelanggan.create');

    Route::post('/pelanggan', [AdminController::class, 'pelangganStore'])
        ->name('admin.pelanggan.store');

    Route::get('/pelanggan/{pelanggan}/edit', [AdminController::class, 'pelangganEdit'])
        ->name('admin.pelanggan.edit');

    Route::put('/pelanggan/{pelanggan}', [AdminController::class, 'pelangganUpdate'])
        ->name('admin.pelanggan.update');

    Route::delete('/pelanggan/{pelanggan}', [AdminController::class, 'pelangganDestroy'])
        ->name('admin.pelanggan.destroy');

    /*
    |--------------------------------------------------------------------------
    | PETUGAS
    |--------------------------------------------------------------------------
    */
    Route::get('/petugas', [AdminController::class, 'petugasIndex'])
        ->name('admin.petugas.index');

    Route::get('/petugas/create', [AdminController::class, 'createPetugas'])
        ->name('admin.petugas.create');

    Route::post('/petugas', [AdminController::class, 'storePetugas'])
        ->name('admin.petugas.store');

    Route::get('/petugas/{petugas}/edit', [AdminController::class, 'editPetugas'])
        ->name('admin.petugas.edit');

    Route::put('/petugas/{petugas}', [AdminController::class, 'updatePetugas'])
        ->name('admin.petugas.update');

    Route::delete('/petugas/{petugas}', [AdminController::class, 'destroyPetugas'])
        ->name('admin.petugas.destroy');

    /*
    |--------------------------------------------------------------------------
    | NOTIFIKASI
    |--------------------------------------------------------------------------
    */
    Route::get('/notifikasi', [AdminController::class, 'notifikasiIndex'])
        ->name('admin.notifikasi.index');

    /*
    |--------------------------------------------------------------------------
    | MONITORING
    |--------------------------------------------------------------------------
    */
    Route::get('/monitoring', [AdminController::class, 'monitoring'])
        ->name('admin.monitoring');

    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */
    Route::get('/laporan', [AdminController::class, 'laporan'])
        ->name('admin.laporan');

    Route::get('/laporan/generate', [AdminController::class, 'generateLaporan'])
        ->name('admin.laporan.generate');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT BY ROLE
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {

    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'petugas') {
        return redirect()->route('petugas.dashboard');
    }

    return redirect()->route('pengaduan.index');

})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| DEBUG (OPTIONAL - HAPUS KALAU SUDAH BERES)
|--------------------------------------------------------------------------
*/
Route::get('/debug-auth', function () {
    return [
        'check' => Auth::check(),
        'user' => Auth::user(),
    ];
});

Route::get('/cek-user', function () {
    return \App\Models\User::first();
});

Route::get('/test-session', function () {
    session(['test' => 'PDAM']);
    return 'Session disimpan';
});

Route::get('/read-session', function () {
    return session('test', 'Tidak ada session');
});
