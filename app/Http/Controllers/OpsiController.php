<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use App\Models\Opsi;
use Illuminate\Http\Request;

class OpsiController extends Controller
{
    public function index(Request $request, $pertanyaan_id = null)
    {
        // Jika ada parameter pertanyaan_id
        if ($pertanyaan_id) {
            $pertanyaan = Pertanyaan::find($pertanyaan_id);

            if (!$pertanyaan) {
                return redirect()->back()->withErrors(['error' => 'Pertanyaan tidak ditemukan.']);
            }

            $opsi = Opsi::where('pertanyaan_id', $pertanyaan_id)->get();
        } else {
            // Ambil semua opsi jika pertanyaan_id tidak ada
            $opsi = Opsi::all();
            $pertanyaan = null;
        }

        return view('opsi.index', compact('opsi', 'pertanyaan'));
    }

    public function create($pertanyaan_id)
    {
        // Cari pertanyaan berdasarkan ID
        $pertanyaan = Pertanyaan::find($pertanyaan_id);

        if (!$pertanyaan) {
            return redirect()->back()->withErrors(['error' => 'Pertanyaan tidak ditemukan.']);
        }

        return view('opsi.create', compact('pertanyaan'));
    }

    public function store(Request $request, $pertanyaan_id)
    {
        // Validasi input
        $request->validate([
            'opsi' => 'required|string|max:255',
            'status' => 'required|boolean', // Menyesuaikan dengan tipe data boolean
        ]);

        // Cari pertanyaan berdasarkan ID
        $pertanyaan = Pertanyaan::find($pertanyaan_id);

        if (!$pertanyaan) {
            return redirect()->back()->withErrors(['error' => 'Pertanyaan tidak ditemukan.']);
        }

        // Simpan opsi
        Opsi::create([
            'pertanyaan_id' => $pertanyaan_id,
            'opsi' => $request->opsi,
            'status' => (bool) $request->status, // Pastikan status disimpan sebagai boolean
        ]);

        return redirect()
            ->route('opsi.index', $pertanyaan_id)
            ->with('success', 'Opsi berhasil ditambahkan.');
    }
}
