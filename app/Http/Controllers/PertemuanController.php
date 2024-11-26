<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pertemuan;
use Illuminate\Http\Request;
class PertemuanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'guru') {
            $pertemuan = Pertemuan::all();  
            return view('guru.aktifitas', compact('pertemuan')); 
        }

        if ($user->role === 'siswa') {
            $pertemuan = Pertemuan::all(); 
            return view('siswa.classroom', compact('pertemuan')); 
        }

        return redirect()->route('login')->with('error', 'Anda tidak memiliki izin untuk mengakses materi ini.');
    }

    public function create()
    {
        return view('classRoom.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
        ]);

        Pertemuan::create([
            'judul' => $request->judul,
        ]);

        return redirect()->route('guru.aktifitas')->with('success', 'Pertemuan berhasil ditambahkan!');
    }

    public function show($id)
    {
    $pertemuan = Pertemuan::findOrFail($id); // Ambil data pertemuan berdasarkan ID
    $aktifitas = $pertemuan->aktifitas; // Relasi: Ambil semua aktivitas yang terkait dengan pertemuan

    return view('aktifitas.show', compact('pertemuan', 'aktifitas'));
    }

    public function edit(Pertemuan $pertemuan)
    {
        return view('classRoom.edit', compact('pertemuan'));
    }

    public function update(Request $request, Pertemuan $pertemuan)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
        ]);

        $pertemuan->update([
            'judul' => $request->judul, 
        ]);

        return redirect()->route('guru.aktifitas')->with('success', 'Pertemuan berhasil diperbarui!');
    }

    public function destroy(Pertemuan $pertemuan)
    {
        $pertemuan->delete(); // Menghapus data materi
        return redirect()->route('guru.aktifitas')->with('success', 'Materi berhasil dihapus!');
    }
}
