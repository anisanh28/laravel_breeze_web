<?php

namespace App\Http\Controllers;

use App\Models\Submateri;
use App\Models\Materi;
use App\Models\User;
use App\Models\JawabanWarmUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmateriController extends Controller
{
    public function index(Request $request, $materi_id)
    {
        if ($materi_id) {
            $submateri = Submateri::where('materi_id', $materi_id)->get();
            $materi = Materi::find($materi_id); 
        } else {
            $submateri = Submateri::all();
            $materi = null;
        }

        return view('submateri.index', compact('submateri', 'materi', 'materi_id'));
    }

    public function create($materi_id)
    {
        $submateri = Submateri::all(); // Example: Retrieve all materi to choose from
        return view('submateri.create', compact('submateri', 'materi_id'));
    }

    //Menyimpan form inputan
    public function store(Request $request, $materi_id)
    {
        $request->validate([
            'judulSubMateri' => 'required|string|max:255',
            'tujuanPembelajaran' => 'required|string|max:255',
            'content' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx,zip,png,jpg,jpeg,mp3,mp4,|max:102400',
            'soal_warm_up' => 'required|string'
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
            'file' => $filePath ?? null,
            'soal_warm_up' => $request->soal_warm_up?? null,
        ]);

        return redirect()->route('submateri.index', compact('materi_id'))->with('success', 'SubMateri berhasil ditambahkan!');
    }

    // Menampilkan detail submateri
    public function show(Materi $materi, SubMateri $submateri)
    {
        // Check if the submateri belongs to the given materi
        if ($submateri->materi_id !== $materi->id) {
            abort(404, 'Submateri not found in this Materi');
        }

        $user = Auth::user();
        $jawabanWarmUp = JawabanWarmUp::where('submateri_id', $submateri->id)
            ->where('user_id', $user->id)
            ->first();  // Get the results

        return view('submateri.show', compact('materi', 'submateri', 'jawabanWarmUp'));
    }
    //Mengedit inputan
    public function edit($id)
    {
        $submateri = Submateri::findOrFail($id); // Mengambil data submateri berdasarkan ID
        $materi = Materi::all(); // Mendapatkan daftar semua materi
        return view('submateri.edit', compact('submateri', 'materi'));
    }

    //Update database
    public function update(Request $request, $id)
    {
    $request->validate([
        'judulSubMateri' => 'required|string|max:255',
        'tujuanPembelajaran' => 'required|string',
        'content' => 'required|string',
        'file' => 'nullable|file|mimes:pdf,doc,docx,zip,png,jpg,jpeg,mp3,mp4|max:102400',
        'soal_warm_up' => 'required|string'
    ]);

    $submateri = Submateri::findOrFail($id);

    // Update fields
    $submateri->judulSubMateri = $request->judulSubMateri;
    $submateri->tujuanPembelajaran = $request->tujuanPembelajaran;
    $submateri->content = $request->content;
    $submateri->soal_warm_up = $request->soal_warm_up;

    // Update file if a new file is uploaded
    if ($request->hasFile('file')) {
        $filePath = $request->file('file')->store('uploads', 'public');
        $submateri->file = $filePath;
    }

    $submateri->save();

    return redirect()->route('submateri.index', ['materi_id' => $submateri->materi_id])
        ->with('success', 'Submateri berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $submateri = Submateri::findOrFail($id);
        $submateri->delete();

        return redirect()->route('submateri.index', ['materi_id' => $submateri->materi_id])
        ->with('success', 'Submateri berhasil dihapus');
    }
}
