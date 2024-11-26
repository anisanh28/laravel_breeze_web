<?php

namespace App\Http\Controllers;
use App\Models\Evaluasi;
use App\Models\HasilEvaluasi;
use App\Models\Pertanyaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasilEvaluasiController extends Controller
{
    public function index(){
        $pertanyaan = Pertanyaan::all(); // atau sesuai model Anda
        $hasilEvaluasi = HasilEvaluasi::with('user')->get();

        foreach ($hasilEvaluasi as $evaluasi) {
            $evaluasi->jawaban = json_decode($evaluasi->jawaban, true); // Menambahkan parameter true untuk mengonversi menjadi array
        }

        return view('guru.hasilEvaluasi', compact('pertanyaan','hasilEvaluasi'));
    }
}
