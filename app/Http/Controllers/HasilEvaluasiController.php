<?php

namespace App\Http\Controllers;
use App\Models\Evaluasi;
use App\Models\HasilEvaluasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasilEvaluasiController extends Controller
{
    public function index(){
    // Ambil semua data hasil_evaluasi dengan relasi ke evaluasi dan user
    $hasilEvaluasi = HasilEvaluasi::with(['evaluasi', 'user'])->get();

    return view('guru.hasilEvaluasi', compact('hasilEvaluasi'));
    }
}
