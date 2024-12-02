<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use App\Models\HasilEvaluasi;
use App\Models\Pertanyaan;
use App\Models\Opsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EvaluasiController extends Controller
{
    // Show the list of evaluations
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

    // Show the form to create a new evaluation
    public function create()
    {
        return view('evaluasi.create');
    }

    // Store the newly created evaluation
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
            'start_time' => Carbon::parse($request->start_time)->setTimezone('Asia/Jakarta'),
            'end_time' => Carbon::parse($request->end_time)->setTimezone('Asia/Jakarta'),
            'durasi' => $request->durasi,
        ]);

        return redirect()->route('guru.evaluasi')->with('success', 'Evaluasi berhasil ditambahkan!');
    }

    // Show the details of an evaluation
    // Show the details of an evaluation
public function show($id)
{
    $user = Auth::user();
    $evaluasi = Evaluasi::with('pertanyaan.opsi')->findOrFail($id);

    // Check if the user has already submitted the evaluation
    $hasSubmitted = HasilEvaluasi::where('evaluasi_id', $id)
                                ->where('user_id', $user->id)
                                ->exists();

    if ($hasSubmitted) {
        // Redirect to the result page if the user has already submitted the evaluation
        $hasilEvaluasi = HasilEvaluasi::where('evaluasi_id', $id)
                                    ->where('user_id', $user->id)
                                    ->first();

        return redirect()->route('evaluasi.showSkor', ['id' => $hasilEvaluasi->id]);
    }

    // If user is a teacher
    if ($user->role === 'guru') {
        $pertanyaan = $evaluasi->pertanyaan;
        return view('evaluasi.show', compact('evaluasi', 'pertanyaan'));
    }

    // If user is a student
    if ($user->role === 'siswa') {
        $pertanyaan = $evaluasi->pertanyaan;
        return view('evaluasi.detail', compact('evaluasi', 'pertanyaan'));
    }

    return redirect()->route('login')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
}


    // Show the form to edit an evaluation
    public function edit(Evaluasi $evaluasi)
    {
        return view('evaluasi.edit', compact('evaluasi'));
    }

    // Update an evaluation
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
            'start_time' => Carbon::parse($request->start_time)->setTimezone('Asia/Jakarta'),
            'end_time' => Carbon::parse($request->end_time)->setTimezone('Asia/Jakarta'),
            'durasi' => $request->durasi,
        ]);

        return redirect()->route('guru.evaluasi')->with('success', 'Evaluasi berhasil diperbarui!');
    }

    // Delete an evaluation
    public function destroy(Evaluasi $evaluasi)
    {
        $evaluasi->delete();
        return redirect()->route('guru.evaluasi')->with('success', 'Evaluasi berhasil dihapus!');
    }

    // Submit answers for an evaluation
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

        // Prepare a formatted jawaban array and calculate the score
        $formattedJawaban = [];
        $skor = 0;

        foreach ($pertanyaan as $index => $pertanyaanItem) {
            $questionIndex = $index + 1; // Get the question index (starting from 1)

            $mappedOptions = [];
            foreach ($pertanyaanItem->opsi as $optionIndex => $option) {
                $optionLabel = chr(65 + $optionIndex); // Convert index to A, B, C, etc.
                $mappedOptions[$option->id] = $optionLabel; // Map option ID to label
            }

            // Find the correct option for this question
            $correctOption = $pertanyaanItem->opsi->where('status', 1)->first();

            // Default user answer for this question
            $userAnswer = null;

            if (isset($jawaban[$pertanyaanItem->id])) {
                $userAnswerId = $jawaban[$pertanyaanItem->id];
                $userAnswer = $mappedOptions[$userAnswerId] ?? null;

                // Compare the user's answer with the correct option to calculate score
                if ($correctOption && $userAnswerId == $correctOption->id) {
                    $skor += $pertanyaanItem->skor;
                }
            }

            // Add formatted answer to the array
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

    // Show the score of an evaluation result
    public function showSkor($id)
    {
        $pertanyaan = Pertanyaan::with('opsi')->get();
        $hasilEvaluasi = HasilEvaluasi::with('evaluasi')->findOrFail($id);

        return view('evaluasi.hasil', [
            'hasilEvaluasi' => $hasilEvaluasi,
            'evaluasi' => $hasilEvaluasi->evaluasi,
        ]);
    }
}
