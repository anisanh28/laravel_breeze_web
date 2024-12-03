<?php

namespace App\Http\Controllers;
use App\Models\WaktuAkses;
use App\Models\User;
use App\Models\Submateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WaktuAksesController extends Controller
{
    // Fungsi untuk mencatat waktu mulai mengakses submateri
    public function mulaiAkses(Request $request, $submateri_id)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id', 
            'submateri_id' => 'required|exists:submateri,id', 
        ]);

        // Menyimpan waktu mulai di session
        session(['start_time' => Carbon::now()]);

        // Mencatat waktu mulai akses di tabel WaktuAkses
        $waktuAkses = new WaktuAkses();
        $waktuAkses->user_id = $request->user_id;
        $waktuAkses->submateri_id = $submateri_id;
        $waktuAkses->waktu_mulai = Carbon::now(); 
        $waktuAkses->durasi = 0; 
        $waktuAkses->save();

        return response()->json(['message' => 'Akses dimulai', 'data' => $waktuAkses], 200);
    }

    // Fungsi untuk mencatat waktu selesai mengakses submateri dan menghitung durasi
    public function selesaiAkses($waktuAkses_id)
    {
        // Mencari waktu akses berdasarkan ID
        $waktuAkses = WaktuAkses::find($waktuAkses_id);
        
        if (!$waktuAkses) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Mengambil waktu mulai dari session
        $startTime = session('start_time');
        if (!$startTime) {
            return response()->json(['message' => 'Waktu mulai tidak ditemukan'], 400);
        }

        // Mencatat waktu selesai
        $endTime = Carbon::now();
        $waktuAkses->waktu_selesai = $endTime; // Gunakan waktu sekarang untuk waktu selesai

        // Menghitung durasi dalam detik
        $waktuAkses->durasi = $startTime->diffInSeconds($endTime); 
        $waktuAkses->save();

        // Menghapus session start_time setelah selesai
        session()->forget('start_time');

        return response()->json(['message' => 'Akses selesai', 'data' => $waktuAkses], 200);
    }

    // Fungsi untuk mendapatkan data waktu akses tertentu
    public function show($waktuAkses_id)
    {
        $waktuAkses = WaktuAkses::find($waktuAkses_id);

        if (!$waktuAkses) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['data' => $waktuAkses], 200);
    }

    // Fungsi untuk mendapatkan semua waktu akses dari user tertentu
    public function userAkses($user_id)
    {
        $user = User::find($user_id);
        
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        // Mendapatkan semua waktu akses yang dimiliki oleh user
        $waktuAkses = $user->waktuAkses;

        return response()->json(['data' => $waktuAkses], 200);
    }

    // Fungsi untuk mendapatkan semua waktu akses dari submateri tertentu
    public function submateriAkses($submateri_id)
    {
        $submateri = Submateri::find($submateri_id);

        if (!$submateri) {
            return response()->json(['message' => 'Submateri tidak ditemukan'], 404);
        }

        // Mendapatkan semua waktu akses yang terkait dengan submateri
        $waktuAkses = $submateri->waktuAkses;

        return response()->json(['data' => $waktuAkses], 200);
    }
    public function store(Request $request)
    {
        try {
            // Validasi data yang diterima
            $validated = $request->validate([
                'submateri_id' => 'required|exists:submateri,id',
                'user_id' => 'required|exists:users,id',
                'waktu_mulai' => 'required|date',
                'waktu_selesai' => 'required|date',
                'durasi' => 'required|integer',
            ]);

            return response()->json(['message' => 'Waktu akses berhasil disimpan.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan waktu akses.', 'error' => $e->getMessage()], 500);
        }
    }
}