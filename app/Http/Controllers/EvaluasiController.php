<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use App\Models\HasilEvaluasi;
use App\Models\Pertanyaan;
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

    private function hitungSkor($jawaban, $evaluasi_id)
    {
        $evaluasi = Evaluasi::find($evaluasi_id);
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
        // Validate the request data
        $request->validate([
            'evaluasi_id' => 'required|exists:evaluasis,id',
            'jawaban' => 'required|json',
            'waktu_pengerjaan' => 'required|integer|min:0', // Validate the time spent
        ]);

        // Fetch pertanyaan with options for the given evaluasi_id
        $pertanyaan = Pertanyaan::with('opsi')->where('evaluasi_id', $request->input('evaluasi_id'))->get();

        // Decode the answers from JSON
        $jawaban = json_decode($request->input('jawaban'), true);

        // Check for any JSON decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Format jawaban tidak valid.'], 400);
        }

        // Calculate the score based on the provided answers
        $skor = 0;

        foreach ($pertanyaan as $pertanyaanItem) {
            // Get the question ID and find the correct option for this question
            $questionId = $pertanyaanItem->id;
            $correctOption = $pertanyaanItem->opsi->where('status', 1)->first();
            // If the correct option is found
            if ($correctOption) {
                $correctOptionId = $correctOption->id;

                // Check if an answer exists for this question in the jawaban array
                if (isset($jawaban[$questionId])) {
                    $userAnswerId = $jawaban[$questionId];

                    // Compare the user's answer with the correct option
                    if ($userAnswerId == $correctOptionId) {
                        $skor = $skor + $pertanyaanItem->skor;
                    }
                }
            }
        }

        // Save the evaluation result
        $hasilEvaluasi = new HasilEvaluasi();
        $hasilEvaluasi->evaluasi_id = $request->input('evaluasi_id');
        $hasilEvaluasi->user_id = Auth::id();  // The ID of the authenticated user
        $hasilEvaluasi->skor = $skor;
        $hasilEvaluasi->waktu_pengerjaan = $request->input('waktu_pengerjaan');  // Store the time spent
        $hasilEvaluasi->save();

        // Return success response with the result ID
        return response()->json(['success' => true, 'id' => $hasilEvaluasi->id]);
    }


    public function showSkor($id)
    {
        $hasilEvaluasi = HasilEvaluasi::with('evaluasi')->findOrFail($id);

        // Tampilkan halaman dengan skor hasil evaluasi
        return view('evaluasi.hasil', ['hasilEvaluasi' => $hasilEvaluasi, 'evaluasi' => $hasilEvaluasi->evaluasi, // Pastikan relasi tersedia
        ]);
    }
}
