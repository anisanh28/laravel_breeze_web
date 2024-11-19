<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class evaluasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'guru') {
            $evaluasi = Evaluasi::all();
            return view('guru.evaluasi', compact('evaluasi'));
        }

        if ($user->role === 'siswa') {
            $evaluasi = Evaluasi::all(); 
            return view('siswa.evaluasi', compact('evaluasi')); 
        }

        return redirect()->route('login')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }

    public function create()
    {
        return view('evaluasi.create');
    }
}
