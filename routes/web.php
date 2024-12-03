<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\SubmateriController;
use App\Http\Controllers\JawabWarmUpController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\EvaluasiController;
use App\Http\Controllers\HasilEvaluasiController;
use App\Http\Controllers\PertemuanController;
use App\Http\Controllers\AktifitasController;
use App\Http\Controllers\LembarKerjaController;
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
Route::resource('evaluasi', EvaluasiController::class);
Route::resource('pertanyaan', PertanyaanController::class);
Route::resource('hasilEvaluasi', HasilEvaluasiController::class);

Route::middleware('auth')->get('/hasil-evaluasi/{evaluasiId}', [HasilEvaluasiController::class, 'tampilkanHasil'])->name('evaluasi.hasil');


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

    Route::get('/classroomactivity', [PertemuanController::class, 'index'])->name('siswa.classroom');
    Route::get('/pertemuan/{id}', [PertemuanController::class, 'show'])->name('pertemuan.show');
    Route::get('aktifitas/{id}', [AktifitasController::class, 'show'])->name('aktifitas.show');


    Route::get('/jawaban-warm-up/create',[JawabWarmUpController::class,'create'])->name('jawabanWarmUp.create');
    Route::get('/jawaban-warm-up/{id}/edit',[JawabWarmUpController::class,'edit'])->name('jawabanWarmUp.edit');
    Route::put('/jawaban-warm-up/{id}',[JawabWarmUpController::class,'update'])->name('jawabanWarmUp.update');
    Route::post('/jawaban-warm-up', [JawabWarmUpController::class, 'store'])->name('jawabanWarmUp.store');
    Route::get('/jawabanWarmUp/{submateri_id}', [JawabWarmUpController::class, 'show'])->name('jawabWarmUp.show');
    Route::delete('/jawaban-warm-up/{id}', [JawabWarmUpController::class, 'destroy'])->name('jawabanWarmUp.destroy');

    Route::get('/evaluasi/{id}', [EvaluasiController::class, 'show'])->name('evaluasi.show');
    Route::get('/pertanyaan/{evaluasi}', [PertanyaanController::class, 'show'])->name('pertanyaan.show');

    Route::post('/submit-evaluasi', [EvaluasiController::class, 'submitEvaluasi'])->name('submitEvaluasi');
    Route::get('/evaluasi/{evaluasi_id}/hasil', [EvaluasiController::class, 'tampilkanHasil'])->name('evaluasi.tampilkanHasil');
    Route::get('hasil-evaluasi/{evaluasiId}', [EvaluasiController::class, 'showSkor'])->name('evaluasi.hasil');
    Route::get('/evaluasi/{id}', [EvaluasiController::class, 'show'])->name('evaluasi.show');
    Route::get('/evaluasi/hasil/{id}', [EvaluasiController::class, 'showSkor'])->name('evaluasi.showSkor');

    Route::get('/lembar-kerja/create',[LembarKerjaController::class,'create'])->name('lembarKerja.create');
    Route::get('/lembar-kerja/{id}/edit',[LembarKerjaController::class,'edit'])->name('lembarKerja.edit');
    Route::put('/lembar-kerja/{id}',[LembarKerjaController::class,'update'])->name('lembarKerja.update');
    Route::post('/lembar-kerja', [LembarKerjaController::class, 'store'])->name('lembarKerja.store');
    Route::get('/lembar-kerja/{pertemuan}/{aktifitas}', [LembarKerjaController::class, 'show'])->name('lembarKerja.show');
    Route::delete('/lembar-kerja/{id}', [LembarKerjaController::class, 'destroy'])->name('lembarKerja.destroy');
});

// Guru Routes (Akses penuh untuk guru)
Route::middleware(['auth', 'guru'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');
    Route::get('/guru/anggota', [GuruController::class, 'anggota'])->name('guru.anggota');
    Route::get('/guru/materi', [MateriController::class, 'index'])->name('guru.materi');
    Route::get('/guru/evaluasi', [EvaluasiController::class, 'index'])->name('guru.evaluasi');
    Route::get('/guru/aktifitas', [PertemuanController::class, 'index'])->name('guru.aktifitas');

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

    Route::get('/jawabWarmUp/{submateri_id}', [JawabWarmUpController::class, 'index'])->name('jawabWarmUp.index');
    Route::get('/lembarKerja/{aktifitas_id}', [LembarKerjaController::class, 'index'])->name('lembarKerja.index');

    Route::get('/evaluasi/create', [EvaluasiController::class, 'create'])->name('evaluasi.create');
    Route::post('/pertanyaan/{evaluasi}', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
    Route::get('/evaluasi/{evaluasi}/edit', [EvaluasiController::class, 'edit'])->name('evaluasi.edit');
    Route::put('/evaluasi/{evaluasi}', [EvaluasiController::class, 'update'])->name('evaluasi.update');
    Route::delete('/evaluasi/{id}', [EvaluasiController::class, 'destroy'])->name('evaluasi.destroy');
    Route::get('/evaluasi/{id}', [EvaluasiController::class, 'show'])->name('evaluasi.show');

    Route::get('hasilEvaluasi', [HasilEvaluasiController::class, 'index'])->name('hasilEvaluasi.index');

    Route::get('/pertemuan/create', [pertemuanController::class, 'create'])->name('pertemuan.create');
    Route::post('/pertemuan', [PertemuanController::class, 'store'])->name('pertemuan.store');
    Route::get('/pertemuan/{pertemuan}/edit', [PertemuanController::class, 'edit'])->name('pertemuan.edit');
    Route::put('/pertemuan/{pertemuan}', [PertemuanController::class, 'update'])->name('pertemuan.update');
    Route::delete('/pertemuan/{pertemuan}', [PertemuanController::class, 'destroy'])->name('pertemuan.destroy');

    Route::get('{pertemuan_id}/aktifitas', [AktifitasController::class, 'index'])->name('aktifitas.index');
    Route::get('{pertemuan_id}/aktifitas/create', [AktifitasController::class,'create'])->name('aktifitas.create');
    Route::post('{pertemuan_id}/aktifitas}', [AktifitasController::class, 'store'])->name('aktifitas.store');
    Route::get('/aktifitas/{id}/edit', [AktifitasController::class, 'edit'])->name('aktifitas.edit');
    Route::put('/aktifitas/{id}', [AktifitasController::class, 'update'])->name('aktifitas.update');
    Route::delete('/aktifitas/{id}', [AktifitasController::class, 'destroy'])->name('aktifitas.destroy');

});

require __DIR__.'/auth.php';
