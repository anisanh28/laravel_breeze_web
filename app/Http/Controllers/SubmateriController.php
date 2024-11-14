<?php

namespace App\Http\Controllers;

use App\Models\Submateri;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmateriController extends Controller
{
    //Menampilkan semua submateri
    public function index(Request $request)
{
    // Ambil materi_id dari URL query parameter
    $materi_id = $request->get('materi_id');

    if ($materi_id) {
        $submateri = Submateri::where('materi_id', $materi_id)->get();
        $materi = Materi::find($materi_id); // Ambil materi berdasarkan materi_id
    } else {
        $submateri = Submateri::all();
        $materi = null;
    }

    return view('submateri.index', compact('submateri', 'materi', 'materi_id'));
}

    //Menampilkan form untuk membuat submateri baru
    
    public function create()
    {
        $submateri = Submateri::all(); // Example: Retrieve all materi to choose from
        return view('submateri.create', compact('submateri'));
    }



    public function store(Request $request, $materi_id)
{
    $request->validate([
        // 'materi_id' => 'required|exists:materi,id', // Validasi materi_id
        'judulSubMateri' => 'required|string|max:255',
        'tujuanPembelajaran' => 'required|string|max:255',
        'content' => 'required|string',
        'file' => 'required|file|mimes:pdf,doc,docx,zip' // Validasi file
    ]);

    // Proses upload file
    if ($request->hasFile('file')) {
        $filePath = $request->file('file')->store('uploads', 'public');
    }

    Submateri::create([
        'materi_id' => $materi_id,
        'judulSubMateri' => $request->judulSubMateri,
        'tujuanPembelajaran' => $request->tujuanPembelajaran,
        'content' => $request->content,
        'file' => $filePath ?? null, // Menyimpan jalur file
    ]);

    return redirect()->route('submateri.index')->with('success', 'SubMateri berhasil ditambahkan!');
}

    public function edit($id)
    {
        $submateri = Submateri::findOrFail($id);
        $materis = Materi::all();
        return view('submateri.edit', compact('submateri', 'materis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'materi_id' => 'required|exists:materi,id',
            'judulSubMateri' => 'required|string|max:255',
            'tujuanPembelajaran' => 'required|string',
            'content' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,png,pdf,docx'
        ]);

        $submateri = Submateri::findOrFail($id);
        $submateri->materi_id = $request->materi_id;
        $submateri->judulSubMateri = $request->judulSubMateri;
        $submateri->tujuanPembelajaran = $request->tujuanPembelajaran;
        $submateri->content = $request->content;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('submateri_files', 'public');
            $submateri->file = $filePath;
        }

        $submateri->save();

        return redirect()->route('submateri.index')->with('success', 'Submateri updated successfully.');
    }

    public function destroy($id)
    {
        $submateri = Submateri::findOrFail($id);
        $submateri->delete();

        return redirect()->route('submateri.index')->with('success', 'Submateri deleted successfully.');
    }
}