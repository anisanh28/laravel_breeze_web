<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use App\Models\HasilEvaluasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    public function show($id){

    $user = Auth::user();
    $evaluasi = Evaluasi::with('pertanyaan.opsi')->findOrFail($id);

    if ($user->role === 'guru') {
        $pertanyaan = $evaluasi->pertanyaan;
        return view('evaluasi.show', compact('evaluasi', 'pertanyaan'));
    }

    if ($user->role === 'siswa') {
        $pertanyaan = $evaluasi->pertanyaan;
        return view('evaluasi.detail', compact('evaluasi', 'pertanyaan'));
    }
    return redirect()->route('login')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
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

    private function hitungSkor($jawaban, $evaluasiId)
    {
        $evaluasi = Evaluasi::find($evaluasiId);
        $skor = 0;

        foreach ($evaluasi->pertanyaan as $index => $pertanyaan) {
            if (isset($jawaban[$index]) && $jawaban[$index] == $pertanyaan->status) {
                $skor += $pertanyaan->skor; // Skor disesuaikan dengan nilai pertanyaan
            }
        }
        return $skor;
    }

    public function submitEvaluasi(Request $request)
    {
        $request->validate([
            'evaluasi_id' => 'required|exists:evaluasis,id',
            'jawaban' => 'required|json',
        ]);

        // Decode jawaban
        $jawaban = json_decode($request->input('jawaban'), true);

        // Cek apakah jawaban valid
        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->back()->withErrors('Format jawaban tidak valid.');
        }

        $skor = $this->hitungSkor($jawaban, $request->input('evaluasi_id'));

        // Simpan hasil evaluasi tanpa menyimpan jawaban
        $hasilEvaluasi = new HasilEvaluasi();
        $hasilEvaluasi->evaluasi_id = $request->input('evaluasi_id');
        $hasilEvaluasi->user_id = Auth::id(); // Menyimpan user_id yang login
        $hasilEvaluasi->skor = $skor;
        $hasilEvaluasi->save();

        // Redirect ke halaman hasil evaluasi
        return redirect()->route('evaluasi.hasil', ['id' => $hasilEvaluasi->id])->with('success', 'Evaluasi berhasil disubmit!');
    }

    public function showSkor($id)
    {
        $hasilEvaluasi = HasilEvaluasi::with('evaluasi')->findOrFail($id);

        // Tampilkan halaman dengan skor hasil evaluasi
        return view('evaluasi.hasil', compact('hasilEvaluasi'));
    }
}
