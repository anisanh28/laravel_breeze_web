<?php

namespace App\Http\Controllers;
use App\Models\Evaluasi;
use App\Models\HasilEvaluasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasilEvaluasiController extends Controller
{
    public function submitEvaluasi(Request $request, $evaluasi_id)
    {
        // Ambil jawaban siswa dari request
        $jawabanSiswa = $request->input('jawaban');
        $evaluasi = Evaluasi::findOrFail($evaluasi_id);

        $skor = 0;

        // Hitung skor berdasarkan jawaban siswa
        foreach ($evaluasi->pertanyaan as $index => $pertanyaan) {
            if (isset($jawabanSiswa[$index]) && $jawabanSiswa[$index] == $pertanyaan->jawaban_benar) {
                $skor++;
            }
        }

        // Ambil user_id dari pengguna yang sedang login
        $user_id = Auth::user()->id;

        // Simpan hasil evaluasi ke database
        HasilEvaluasi::create([
            'evaluasi_id' => $evaluasi_id,
            'user_id' => $user_id,
            'skor' => $skor,
        ]);

        // Redirect ke halaman hasil evaluasi
        return redirect()->route('evaluasi.hasil', ['evaluasi_id' => $evaluasi_id]);
    }

    // Method untuk menampilkan hasil evaluasi
    public function tampilkanHasil($evaluasi_id)
    {
        $evaluasi = Evaluasi::findOrFail($evaluasi_id);
        $user_id = Auth::user()->id;

        // Ambil hasil evaluasi berdasarkan evaluasi_id dan user_id
        $hasil = HasilEvaluasi::where('evaluasi_id', $evaluasi_id)
            ->where('user_id', $user_id)
            ->first();

        // Tampilkan halaman hasil evaluasi
        return view('evaluasi.hasil', compact('evaluasi', 'hasil'));
    }

}
