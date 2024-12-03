<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WaktuAkses;
use Carbon\Carbon;

class CatatWaktuAkses
{
    // Menyimpan waktu mulai
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user terautentikasi
        if (Auth::check()) {
            // Cek apakah user sedang mengakses halaman submateri
            if ($request->routeIs('submateri.show')) {
                // Membuat record baru untuk waktu akses
                $waktuAkses = new WaktuAkses();
                $waktuAkses->user_id = Auth::id();  // Menggunakan Auth::id() yang benar
                $waktuAkses->submateri_id = $request->route('submateri_id');
                $waktuAkses->waktu_mulai = Carbon::now();
                $waktuAkses->save();

                // Menyimpan ID WaktuAkses di session untuk nanti mencatat waktu selesai
                session(['waktu_akses_id' => $waktuAkses->id]);
            }
        }

        return $next($request);
    }

    // Menangani waktu selesai setelah mengakses
    public function terminate(Request $request, $response)
    {
        // Cek apakah session waktu akses ada
        if (session()->has('waktu_akses_id')) {
            // Ambil data WaktuAkses berdasarkan ID yang disimpan di session
            $waktuAkses = WaktuAkses::find(session('waktu_akses_id'));

            if ($waktuAkses) {
                // Set waktu selesai dan durasi
                $waktuAkses->waktu_selesai = Carbon::now();
                $waktuAkses->durasi = $waktuAkses->waktu_mulai->diffInSeconds($waktuAkses->waktu_selesai);
                $waktuAkses->save();

                // Menghapus session setelah selesai
                session()->forget('waktu_akses_id');
            }
        }

        return $response;
    }
}
