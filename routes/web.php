<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\SubmateriController;
use Illuminate\Support\Facades\Route;

// Halaman utama dan Tentang Kami
Route::get('/', function () {
    return view('welcome');
});
Route::get('/tentangkami', function () {
    return view('tentangkami');
});

// Resource route untuk materi dan submateri
Route::resource('materi', MateriController::class);
Route::resource('submateri', SubmateriController::class);

// Middleware untuk autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Siswa Routes (Akses materi hanya untuk index dan show)
Route::middleware(['auth', 'siswa'])->group(function () {
    Route::get('dashboard', [SiswaController::class, 'index'])->name('dashboard');
    Route::get('/materi', [MateriController::class, 'index'])->name('materi.siswa');
    Route::get('/materi/{materi}', action: [MateriController::class, 'show'])->name('materi.show');
    Route::get('/materi/{materi}/submateri/{submateri}', [SubMateriController::class, 'show'])->name('submateri.show');

});

// Guru Routes (Akses penuh untuk guru)
Route::middleware(['auth', 'guru'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');
    Route::get('/guru/anggota', [GuruController::class, 'anggota'])->name('guru.anggota');
    Route::get('/guru/materi', [MateriController::class, 'index'])->name('guru.materi'); // Akses materi untuk guru
    Route::get('/materi/create', [MateriController::class, 'create'])->name('materi.create'); // Form untuk membuat materi
    Route::post('/materi', [MateriController::class, 'store'])->name('materi.store'); // Menyimpan materi
    Route::get('/materi/{materi}/edit', [MateriController::class, 'edit'])->name('materi.edit'); // Form untuk edit materi
    Route::put('/materi/{materi}', [MateriController::class, 'update'])->name('materi.update'); // Update materi
    Route::delete('/materi/{materi}', [MateriController::class, 'destroy'])->name('materi.destroy'); // Menghapus materi

    Route::get('{materi_id}/submateri', [SubmateriController::class, 'index'])->name('submateri.index');
    Route::get('{materi_id}/submateri/create', [SubmateriController::class,'create'])->name('submateri.create');
    Route::post('{materi_id}/submateri}', [SubmateriController::class, 'store'])->name('submateri.store'); // Menyimpan materi
    Route::get('/submateri/{id}/edit', [SubmateriController::class, 'edit'])->name('submateri.edit');
    Route::put('/submateri/{id}', [SubmateriController::class, 'update'])->name('submateri.update');
    Route::delete('/submateri/{id}', [SubmateriController::class, 'destroy'])->name('submateri.destroy');

});

require __DIR__.'/auth.php';
