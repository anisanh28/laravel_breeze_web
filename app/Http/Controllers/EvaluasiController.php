<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluasiController extends Controller
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

    public function store(Request $request)
    {
        $request->validate([
            'judul_evaluasi' => 'required|string|max:255',
            'deskripsi_evaluasi' => 'required|string|max:255',
            'start_time' => 'required|date|after_or_equal:today',
            'end_time' => 'required|date|after:start_time',
            'durasi' => 'required|date_format:H:i',
        ]);

        Evaluasi::create([
            'judul_evaluasi' => $request->judul_evaluasi,
            'deskripsi_evaluasi' => $request->deskripsi_evaluasi,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'durasi' => $request->durasi,
        ]);
        return redirect()->route('guru.evaluasi')->with('success', 'Evaluasi berhasil ditambahkan!');
    }

    public function show(Evaluasi $evaluasi)
    {
        return view('evaluasi.show', compact('evaluasi'));
    }

    public function edit(Evaluasi $evaluasi)
    {
        return view('evaluasi.edit', compact('evaluasi'));
    }

    public function update(Request $request, Evaluasi $evaluasi)
    {
        $request->validate([
            'judul_evaluasi' => 'required|string|max:255',
            'deskripsi_evaluasi' => 'required|string|max:255',
            'start_time' => 'required|date|after_or_equal:today',
            'end_time' => 'required|date|after:start_time',
            'durasi' => 'required|date_format:H:i',
        ]);

        $evaluasi->update([
            'judul_evaluasi' => $request->judul_evaluasi,
            'deskripsi_evaluasi' => $request->deskripsi_evaluasi,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'durasi' => $request->durasi,
        ]);

        return redirect()->route('guru.evaluasi')->with('success', 'Evaluasi berhasil diperbarui!');
    }

    public function destroy(Evaluasi $evaluasi)
    {
        $evaluasi->delete();
        return redirect()->route('guru.evaluasi')->with('success', 'Evaluasi berhasil dihapus!');
    }
}
