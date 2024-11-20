<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use App\Models\Pertanyaan;
use App\Models\Opsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PertanyaanController extends Controller
{
    public function index(Request $request, $evaluasi_id)
    {
        if ($evaluasi_id) {
            $pertanyaan = Pertanyaan::where('evaluasi_id', $evaluasi_id)->get();
            $evaluasi = Evaluasi::find($evaluasi_id);
        } else {
            $pertanyaan = Pertanyaan::all();
            $evaluasi = null;
        }
        return view('pertanyaan.index', compact('pertanyaan', 'evaluasi', 'evaluasi_id'));
    }

    public function create($evaluasi_id)
    {
        $evaluasi = Evaluasi::findOrFail($evaluasi_id);
        return view('pertanyaan.create', compact('evaluasi'));
    }

    public function store(Request $request, $evaluasi_id)
    {
        // Validasi
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'skor' => 'required|integer',
            'file' => 'nullable|file|mimes:jpeg,png,pdf,docx,doc|max:10240',
            'opsi' => 'required|array',
            'status' => 'required|array',
            'opsi.*' => 'required|string',
            'status.*' => 'required|in:0,1',
        ]);

        // Simpan pertanyaan
        $pertanyaan = new Pertanyaan();
        $pertanyaan->pertanyaan = $request->pertanyaan;
        $pertanyaan->skor = $request->skor;
        $pertanyaan->evaluasi_id = $evaluasi_id;

        // Menangani upload file jika ada
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
            $pertanyaan->file = $filePath;
        }

        $pertanyaan->save();

        // Menyimpan opsi
        foreach ($request->opsi as $index => $opsi) {
            $opsiModel = new Opsi();
            $opsiModel->pertanyaan_id = $pertanyaan->id;
            $opsiModel->opsi = $opsi;
            $opsiModel->status = $request->status[$index];
            $opsiModel->save();
        }

        // Menyimpan opsi baru jika ada
        if ($request->has('opsi.new')) {
            foreach ($request->opsi['new'] as $index => $newOpsi) {
                if (!empty($newOpsi)) {
                    Opsi::create([
                        'pertanyaan_id' => $pertanyaan->id,
                        'opsi' => $newOpsi,
                        'status' => $request->status['new'][$index] ?? 0, // Status default 0 jika tidak ada
                    ]);
                }
            }
        }

        // Redirect ke halaman evaluasi setelah penyimpanan berhasil
        return redirect()->route('evaluasi.show', $evaluasi_id)->with('success', 'Pertanyaan berhasil ditambahkan');
    }

    public function show(Evaluasi $evaluasi)
    {
        $user = Auth::user();
        // $pertanyaan = Pertanyaan::where('evaluasi_id', $evaluasi->id)->get();

        if($user->role === 'guru'){
            $pertanyaan = Pertanyaan::where('evaluasi_id', $evaluasi->id)->get();

            return view('pertanyaan.show', compact('evaluasi', 'pertanyaan'));
        }

        if($user->role === 'siswa'){
            $pertanyaan = Pertanyaan::where('evaluasi_id', $evaluasi->id)->get();

            return view('siswa.pengerjaan', compact('evaluasi', 'pertanyaan'));
        }
        return redirect()->route('login')->with('error','Anda tidak memiliki izin untuk mengakses halaman ini.');
    }

    public function edit($id)
    {
        $pertanyaan = Pertanyaan::with('opsi')->findOrFail($id);
        return view('pertanyaan.edit', compact('pertanyaan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi
        $request->validate([
            'pertanyaan' => 'required|string',
            'skor' => 'required|integer',
            'file' => 'nullable|file|mimes:jpeg,png,pdf,docx,doc|max:10240',
            'opsi' => 'required|array',
            'status' => 'required|array',
            'opsi.*' => 'required|string',
            'status.*' => 'required|in:0,1',
            'opsi.new' => 'nullable|array',
            'opsi.new.*' => 'required|string',
            'status.new' => 'nullable|array',
            'status.new.*' => 'required|in:0,1',
        ]);

        // Update pertanyaan
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->pertanyaan = $request->pertanyaan;
        $pertanyaan->skor = $request->skor;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
            $pertanyaan->file = $filePath;
        }

        $pertanyaan->save();

        // Update atau hapus opsi lama
        if ($request->has('opsi')) {
            foreach ($request->opsi as $opsiId => $opsiText) {
                if (is_numeric($opsiId)) { // Pastikan hanya opsi lama yang diproses
                    $opsi = Opsi::findOrFail($opsiId);
                    $opsi->opsi = $opsiText;
                    $opsi->status = $request->status[$opsiId];
                    $opsi->save();
                }
            }
        }

        // Tambahkan opsi baru
        if ($request->has('opsi.new')) {
            foreach ($request->opsi['new'] as $index => $newOpsi) {
                if (!empty($newOpsi)) {
                    Opsi::create([
                        'pertanyaan_id' => $pertanyaan->id,
                        'opsi' => $newOpsi,
                        'status' => $request->status['new'][$index] ?? 0,
                    ]);
                }
            }
        }

        // Redirect ke halaman evaluasi setelah update
        return redirect()->route('evaluasi.show', $pertanyaan->evaluasi_id)->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->delete();

        return redirect()->route('evaluasi.show', $pertanyaan->evaluasi_id)->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
