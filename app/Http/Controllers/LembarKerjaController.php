<?php

namespace App\Http\Controllers;
use App\Models\lembarKerja;
use App\Models\Aktifita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LembarKerjaController extends Controller
{
    public function index($aktifitas_id)
    {
        $aktifitas= Aktifita::findOrFail($aktifitas_id);
        $lembarKerja = LembarKerja::where('aktifitas_id', $aktifitas_id)->get();

        return view('lembarKerja.index', compact('aktifitas', 'lembarKerja'));
    }

    public function create($aktifitas_id)
    {
        $aktifitas = Aktifita::findOrFail($aktifitas_id);
        return view('lembarKerja.create', compact('aktifitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aktifitas_id' => 'required|exists:aktifitas,id',
            'lembar_kerja' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,txt,mp4|max:10240',
        ]);

        $lembarKerja = new lembarKerja();
        $lembarKerja->aktifitas_id = $request->aktifitas_id;
        $lembarKerja->user_id = Auth::id();
        $lembarKerja->jawaban = $request->jawaban;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
            $lembarKerja->file = $filePath;
        }

        $lembarKerja->save();

        return redirect()->route('aktitas.show', [
            'pertemuan' => $lembarKerja->aktifitas->pertemuan_id, // Adjust this as per your relationships
            'aktifitas' => $lembarKerja->aktifitas_id,
        ])->with('success', 'Lembar Kerja berhasil diperbarui!');
    }

    public function show($aktifitas_id, $user_id)
    {
    $aktifitas = Aktifita::findOrFail($aktifitas_id);
    $lembarKerja = lembarKerja::where('aktifitas_id', $aktifitas_id)->where('user_id', $user_id)->first();

    return view('aktifitas.show', compact('aktifitas', 'lembarKerja'));
    }

    public function edit($id)
    {
        $lembarKerja= lembarKerja::findOrFail($id);

        if ($lembarKerja->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $aktifitas = Aktifita::findOrFail($lembarKerja->aktifitas_id);

        return view('lembarKerja.edit', compact('aktifitas', 'lembarKerja'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'lembar_kerja' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,txt,mp4|max:10240',
        ]);

        $lembarKerja= lembarKerja::findOrFail($id);

        if ($lembarKerja->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $lembarKerja->lembar_kerja = $request->lembar_kerja;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
            $lembarKerja->lampiran = $filePath;
        }

        $lembarKerja->save();

        return redirect()->route('aktifitas.show', [
            'pertemuan' => $lembarKerja->aktifitas->pertemuan_id, // Adjust this as per your relationships
            'aktifitas' => $lembarKerja->aktifitas_id,
        ])->with('success', 'Lembar Kerja berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $lembarKerja = lembarKerja::findOrFail($id);

        if ($lembarKerja->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $lembarKerja->delete();

        return redirect()->route('aktifitas.show', [
            'pertemuan' => $lembarKerja->aktifitas->materi_id, // Adjust this as per your relationships
            'aktifitas' => $lembarKerja->aktifitas_id,
        ])->with('success', 'Lembar Kerja berhasil dihapus');
    }
}
