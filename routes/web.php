<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\SubmateriController;
use App\Http\Controllers\JawabWarmUpController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\EvaluasiController;
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
Route::resource('jawabanWarmUp', JawabWarmUpController::class);


// Middleware untuk autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'siswa'])->group(function () {
    Route::get('dashboard', [SiswaController::class, 'index'])->name('dashboard');
    Route::get('/materi', [MateriController::class, 'index'])->name('materi.siswa');
    Route::get('/materi/{materi}', action: [MateriController::class, 'show'])->name('materi.show');
    Route::get('/materi/{materi}/submateri/{submateri}', [SubMateriController::class, 'show'])->name('submateri.show');

    Route::get('/jawaban-warm-up/create',[JawabWarmUpController::class,'create'])->name('jawabanWarmUp.create');
    Route::get('/jawaban-warm-up/{id}/edit',[JawabWarmUpController::class,'edit'])->name('jawabanWarmUp.edit');
    Route::patch('/jawaban-warm-up/{id}',[JawabWarmUpController::class,'update'])->name('jawabanWarmUp.update');
    Route::post('/jawaban-warm-up', [JawabWarmUpController::class, 'store'])->name('jawabanWarmUp.store');
    Route::get('/jawaban-warm-up/{id}', [JawabWarmUpController::class, 'show'])->name('jawabanWarmUp.show');
    Route::delete('/jawaban-warm-up/{id}', [JawabWarmUpController::class, 'destroy'])->name('jawabanWarmUp.destroy');

});

// Guru Routes (Akses penuh untuk guru)
Route::middleware(['auth', 'guru'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');
    Route::get('/guru/anggota', [GuruController::class, 'anggota'])->name('guru.anggota');
    Route::get('/guru/materi', [MateriController::class, 'index'])->name('guru.materi');
    Route::get('/guru/evaluasi', [EvaluasiController::class, 'index'])->name('guru.evaluasi');

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

    Route::get('/jawaban-warm-up/{submateri_id}', [JawabWarmUpController::class, 'index'])->name('jawabWarmUp.index');

    Route::get('/evaluasi/create', [EvaluasiController::class, 'create'])->name('evaluasi.create');
    Route::post('/pertanyaan/{evaluasi}', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
    Route::get('/evaluasi/{evaluasi}/edit', [EvaluasiController::class, 'edit'])->name('evaluasi.edit');
    Route::put('/evaluasi/{evaluasi}', [EvaluasiController::class, 'update'])->name('evaluasi.update');
    Route::delete('/evaluasi/{id}', [EvaluasiController::class, 'destroy'])->name('evaluasi.destroy');
    Route::get('/evaluasi/{id}', [EvaluasiController::class, 'show'])->name('evaluasi.show');

    Route::get('{evaluasi_id}/pertanyaan', [PertanyaanController::class, 'index'])->name('pertanyaan.index');
    Route::get('{evaluasi_id}/pertanyaan/create', [PertanyaanController::class,'create'])->name('pertanyaan.create');
    Route::post('{evaluasi_id}/pertanyaan', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
    Route::get('/pertanyaan/{id}/edit', [PertanyaanController::class, 'edit'])->name('pertanyaan.edit');
    Route::put('/pertanyaan/{id}', [PertanyaanController::class, 'update'])->name('pertanyaan.update');
    Route::delete('/pertanyaan/{id}', [PertanyaanController::class, 'destroy'])->name('pertanyaan.destroy');

});

require __DIR__.'/auth.php';
