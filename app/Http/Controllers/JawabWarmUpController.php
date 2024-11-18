<?php

namespace App\Http\Controllers;
use App\Models\JawabanWarmUp;
use App\Models\User;
use App\Models\SubMateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JawabWarmUpController extends Controller
{
    public function index($submateri_id)
    {
        $submateri = SubMateri::findOrFail($submateri_id);
        $jawabanWarmUp = JawabanWarmUp::where('submateri_id', $submateri_id)->get();

        return view('warmUp.index', compact('submateri', 'jawabanWarmUp'));
    }

    public function create($submateri_id)
    {
        $submateri = SubMateri::findOrFail($submateri_id);
        return view('jawabanWarmUp.create', compact('submateri'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'submateri_id' => 'required|exists:submateri,id',
            'jawaban' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,txt,mp4|max:10240',
        ]);

        $jawabanWarmUp = new JawabanWarmUp();
        $jawabanWarmUp->submateri_id = $request->submateri_id;
        $jawabanWarmUp->user_id = Auth::id();
        $jawabanWarmUp->jawaban = $request->jawaban;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
            $jawabanWarmUp->file = $filePath;
        }

        $jawabanWarmUp->save();

        return redirect()->route('jawabanWarmUp.index', $request->submateri_id)->with('success', 'Jawaban berhasil dikirim!');
    }

    public function show($submateri_id, $user_id)
    {
    $submateri = SubMateri::findOrFail($submateri_id);
    $jawabanWarmUp = JawabanWarmUp::where('submateri_id', $submateri_id)->where('user_id', $user_id)->first();

    return view('submateri.show', compact('submateri', 'jawabanWarmUp'));
    }

    public function edit($id)
    {
        $jawabanWarmUp = JawabanWarmUp::findOrFail($id);

        if ($jawabanWarmUp->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $submateri = SubMateri::findOrFail($jawabanWarmUp->submateri_id);

        return view('WarmUp.edit', compact('submateri', 'jawabanWarmUp'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jawaban' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,txt,mp4|max:10240',
        ]);

        $jawabanWarmUp = JawabanWarmUp::findOrFail($id);

        if ($jawabanWarmUp->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $jawabanWarmUp->jawaban = $request->jawaban;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
            $jawabanWarmUp->file = $filePath;
        }

        $jawabanWarmUp->save();

        return redirect()->route('submateri.show', [
            'materi' => $jawabanWarmUp->submateri->materi_id, // Adjust this as per your relationships
            'submateri' => $jawabanWarmUp->submateri_id,
        ])->with('success', 'Jawaban berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jawabanWarmUp = JawabanWarmUp::findOrFail($id);

        if ($jawabanWarmUp->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $jawabanWarmUp->delete();

        return redirect()->route('submateri.show', [
            'materi' => $jawabanWarmUp->submateri->materi_id, // Adjust this as per your relationships
            'submateri' => $jawabanWarmUp->submateri_id,
        ])->with('success', 'Jawaban berhasil dihapus');
    }
}
