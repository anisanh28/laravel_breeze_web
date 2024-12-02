<?php

namespace App\Http\Controllers;


use App\Models\HasilEvaluasi;
use App\Models\Pertanyaan;


class HasilEvaluasiController extends Controller
{
    public function index()
    {
        // Fetching all pertanyaan with their respective correct options
        $pertanyaan = Pertanyaan::with('opsi')->get();

        // Fetching all hasilEvaluasi
        $hasilEvaluasi = HasilEvaluasi::with('user')->get();

        $letterToNumberMap = [];
        foreach (range('A', 'Z') as $index => $letter) {
            $letterToNumberMap[$letter] = $index + 1;
        }

        foreach ($hasilEvaluasi as $evaluasi) {
            $evaluasi->jawaban = json_decode($evaluasi->jawaban, true);
        }

        return view('guru.hasilEvaluasi', compact('pertanyaan', 'hasilEvaluasi', 'letterToNumberMap'));
    }
}
