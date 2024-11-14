<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    // Menampilkan semua materi
    public function index()
    {
        // Cek apakah pengguna yang terautentikasi adalah guru atau siswa
        $user = Auth::user();

        // Jika pengguna adalah guru, tampilkan materi dengan tampilan untuk guru
        if ($user->role === 'guru') {
            $materi = Materi::all();  // Mengambil semua data materi dari tabel 'materis'
            return view('materi.index', compact('materi')); // Tampilan untuk guru
        }

        // Jika pengguna adalah siswa, hanya tampilkan materi untuk siswa
        if ($user->role === 'siswa') {
            $materi = Materi::all();  // Mengambil semua data materi dari tabel 'materis'
            return view('siswa.materi', compact('materi')); // Tampilan untuk siswa
        }

        // Jika pengguna tidak terautentikasi atau role tidak dikenali
        return redirect()->route('login')->with('error', 'Anda tidak memiliki izin untuk mengakses materi ini.');
    }

    // Menampilkan form untuk membuat materi baru
    public function create()
    {
        return view('materi.create');
    }

    // Menyimpan materi baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judulMateri' => 'required|string|max:255', // Validasi untuk 'judulMateri'
        ]);

        // Simpan data ke tabel 'materis'
        Materi::create([
            'judulMateri' => $request->judulMateri, // Menyimpan data materi dengan 'judulMateri'
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('guru.materi')->with('success', 'Materi berhasil ditambahkan!');
    }

    // Menampilkan detail materi
    public function show(Materi $materi)
    {
        return view('materi.show', compact('materi'));
    }

    // Menampilkan form untuk mengedit materi
    public function edit(Materi $materi)
    {
        return view('materi.edit', compact('materi')); // Mengirimkan variabel $materi ke tampilan
    }

    // Memperbarui materi
    public function update(Request $request, Materi $materi)
    {
        $request->validate([
            'judulMateri' => 'required|string|max:255', // Validasi untuk 'judulMateri'
        ]);

        // Memperbarui data materi
        $materi->update([
            'judulMateri' => $request->judulMateri, // Memperbarui data materi dengan 'judulMateri'
        ]);

        return redirect()->route('guru.materi')->with('success', 'Materi berhasil diperbarui!');
    }

    // Menghapus materi
    public function destroy(Materi $materi)
    {
        $materi->delete(); // Menghapus data materi
        return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus!');
    }
}
