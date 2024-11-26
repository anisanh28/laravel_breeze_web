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

    // Prepare a formatted jawaban array
    $formattedJawaban = [];
    $skor = 0;

    foreach ($pertanyaan as $index => $pertanyaanItem) {
        // Get the question index (starting from 1)
        $questionIndex = $index + 1;

        // Map options to A, B, C, etc.
        $mappedOptions = [];
        foreach ($pertanyaanItem->opsi as $optionIndex => $option) {
            $optionLabel = chr(65 + $optionIndex); // Convert index to A, B, C, etc.
            $mappedOptions[$option->id] = $optionLabel; // Map option ID to label
        }

        // Find the correct option for this question
        $correctOption = $pertanyaanItem->opsi->where('status', 1)->first();

        // Default user answer for this question
        $userAnswer = null;

        // Check if an answer exists for this question in the jawaban array
        if (isset($jawaban[$pertanyaanItem->id])) {
            $userAnswerId = $jawaban[$pertanyaanItem->id];

            // Get the label (A, B, C, etc.) of the user-selected option
            $userAnswer = $mappedOptions[$userAnswerId] ?? null;

            // Compare the user's answer ID with the correct option ID to calculate score
            if ($correctOption && $userAnswerId == $correctOption->id) {
                $skor += $pertanyaanItem->skor;
            }
        }

        // Add formatted answer to the array (index => user-selected label or null)
        $formattedJawaban[$questionIndex] = $userAnswer;
    }

    // Save the evaluation result
    $hasilEvaluasi = new HasilEvaluasi();
    $hasilEvaluasi->evaluasi_id = $request->input('evaluasi_id');
    $hasilEvaluasi->user_id = Auth::id(); // The ID of the authenticated user
    $hasilEvaluasi->jawaban = json_encode($formattedJawaban); // Save formatted jawaban
    $hasilEvaluasi->skor = $skor;
    $hasilEvaluasi->waktu_pengerjaan = $request->input('waktu_pengerjaan'); // Store the time spent
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
