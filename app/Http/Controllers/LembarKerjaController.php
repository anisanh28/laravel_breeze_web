<?php

namespace App\Http\Controllers;
use App\Models\lembarKerja;
use App\Models\Aktifita;
use App\Models\Pertemuan;
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
        // dd($request->all());
        // Validasi untuk memastikan data yang diterima sesuai
        $request->validate([
            'aktifitas_id' => 'required|array',
            'aktifitas_id.*' => 'exists:aktifitas,id', // Validasi setiap ID aktivitas
            'lembar_kerja' => 'required|array',
            'lembar_kerja.*' => 'string', // Validasi jawaban untuk setiap aktivitas
            'lampiran.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,txt,mp4|max:10240', // Validasi untuk lampiran (jika ada)
        ]);

        // Loop melalui setiap aktivitas yang dikirimkan
        foreach ($request->aktifitas_id as $index => $aktifitasId) {
            // Membuat objek lembar kerja baru untuk setiap aktivitas
            $lembarKerja = new LembarKerja();
            $lembarKerja->aktifitas_id = $aktifitasId;
            $lembarKerja->user_id = Auth::id();
            $lembarKerja->lembar_kerja = $request->lembar_kerja[$index];

            // Memeriksa apakah ada file lampiran yang diunggah untuk aktivitas ini
            if ($request->hasFile('lampiran.' . $index)) {
                // Menyimpan lampiran dan mendapatkan path-nya
                $filePath = $request->file('lampiran.' . $index)->store('uploads', 'public');
                $lembarKerja->lampiran = $filePath;
            }

            // Menyimpan lembar kerja ke dalam database
            $lembarKerja->save();
        }

        // Setelah menyimpan, kembali ke halaman sebelumnya
        return redirect()->route('siswa.lembarKerja', [
            'pertemuan' => $lembarKerja->aktifitas->pertemuan_id, // Sesuaikan dengan hubungan model Anda
            'aktifitas' => $lembarKerja->aktifitas_id,
        ])->with('success', 'Lembar Kerja berhasil disubmit untuk semua aktivitas!');
    }


    public function show($id)
    {
        $pertemuan = Pertemuan::findOrFail($id); // or whatever logic to get Pertemuan
        $aktifitas = Aktifita::with('lembarKerja')->where('pertemuan_id', $pertemuan->id)->get(); // assuming there's a relationship for lembarKerja
        return view('siswa.lembarKerja', compact('pertemuan', 'aktifitas'));
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
