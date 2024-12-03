<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aktifita;
use App\Models\Pertemuan;
use Illuminate\Support\Facades\Auth;

class AktifitasController extends Controller
{
    public function index(Request $request, $pertemuan_id)
    {
        if ($pertemuan_id) {
            $aktifitas = Aktifita::where('pertemuan_id', $pertemuan_id)->get();
            $pertemuan = Pertemuan::find($pertemuan_id);
        } else {
            $aktifitas = Aktifita::all();
            $materi = null;
        }

        return view('aktifitas.index', compact('aktifitas', 'pertemuan', 'pertemuan_id'));
    }

    public function create($pertemuan_id)
    {
        $submateri = Aktifita::all();
        return view('aktifitas.create', compact( 'pertemuan_id'));
    }

    public function store(Request $request, $pertemuan_id)
    {
        $request->validate([
            'judulAktifitas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,zip,png,jpg,jpeg,mp3,mp4|max:102400',
            'intruksi' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
        }
        Aktifita::create([
            'pertemuan_id' => $pertemuan_id,
            'judulAktifitas' => $request->judulAktifitas,
            'deskripsi' => $request->deskripsi,
            'file' => $filePath ?? null,
            'intruksi' => $request->intruksi,
            //tambahin lembar kerja nanti
        ]);

        return redirect()->route('aktifitas.index', compact('pertemuan_id'))->with('success', 'Aktifitas berhasil ditambahkan!');
    }

    public function show($id)
{
    $pertemuan = Pertemuan::findOrFail($id);
    $aktifitas = $pertemuan->aktifitas;

    return view('aktifitas.show', compact('pertemuan', 'aktifitas'));
}

    public function edit($id)
    {
        $aktifitas = Aktifita ::findOrFail($id);
        $pertemuan = Pertemuan::all();
        return view('aktifitas.edit', compact('aktifitas', 'pertemuan'));
    }

    public function update(Request $request, $id)
    {
    $request->validate([
        'judulAktifitas' => 'required|string|max:255',
        'deskripsi' => 'nullable|string|max:255',
        'file' => 'nullable|file|mimes:pdf,doc,docx,zip,png,jpg,jpeg,mp3,mp4,|max:102400',
        'intruksi' => 'nullable|string',
        //tambahin lembar kerja nanti
    ]);

    $aktifitas = Aktifita::findOrFail($id);

    $aktifitas->judulAktifitas = $request->judulAktifitas;
    $aktifitas->deskripsi = $request->deskripsi;
    $aktifitas->intruksi= $request->intruksi;

    if ($request->hasFile('file')) {
        $filePath = $request->file('file')->store('uploads', 'public');
        $aktifitas->file = $filePath;
    }

    $aktifitas->save();

    return redirect()->route('aktifitas.index', ['pertemuan_id' => $aktifitas->pertemuan_id])
        ->with('success', 'Aktifitas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $aktifitas = Aktifita::findOrFail($id);
        $aktifitas->delete();

        return redirect()->route('aktifitas.index', ['pertemuan_id' => $aktifitas->pertemuan_id])
        ->with('success', 'Aktifitas berhasil dihapus');
    }
}
