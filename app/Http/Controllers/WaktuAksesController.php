<?php

namespace App\Http\Controllers;
use App\Models\WaktuAkses;
use App\Models\User;
use App\Models\Submateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WaktuAksesController extends Controller
{
    public function index($submateri_id)
{
    // Cari submateri berdasarkan ID
    $submateri = Submateri::findOrFail($submateri_id);

    // Ambil data waktu akses berdasarkan submateri_id dan akumulasi durasi per user
    $waktuAksesList = WaktuAkses::where('submateri_id', $submateri_id)
        ->select('user_id', DB::raw('SUM(durasi) as total_durasi'))
        ->groupBy('user_id') // Group by user_id to accumulate durasi
        ->orderBy('total_durasi', 'desc') // Sort by total durasi
        ->get();

    // Loop through and eager load user data based on user_id
    foreach ($waktuAksesList as $akses) {
        $akses->user = User::find($akses->user_id); // Load user info for each record
    }

    // Kirim data ke view
    return view('guru.waktuAkses', compact('waktuAksesList', 'submateri'));
}


        public function store(Request $request)
    {
        // Ubah format ISO 8601 ke MySQL datetime
        $waktu_mulai = Carbon::createFromFormat('Y-m-d\TH:i:s.v\Z', $request->waktu_mulai, 'Asia/Jakarta')->format('Y-m-d H:i:s');
        $waktu_selesai = Carbon::createFromFormat('Y-m-d\TH:i:s.v\Z', $request->waktu_selesai, 'Asia/Jakarta')->format('Y-m-d H:i:s');

        WaktuAkses::create([
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'durasi' => $request->durasi,
            'submateri_id' => $request->submateri_id,
            'user_id' => $request->user_id,
        ]);

        return response()->json(['message' => 'Data berhasil disimpan'], 200);
    }
}
