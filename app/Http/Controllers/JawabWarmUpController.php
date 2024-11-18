<?php

namespace App\Http\Controllers;

use App\Models\JawabWarmUp;
use App\Models\SubMateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JawabWarmUpController extends Controller
{
    public function index($submateri_id)
    {
        $submateri = SubMateri::findOrFail($submateri_id);
        $jawabanWarmUp = JawabWarmUp::where('submateri_id', $submateri_id)->with('user')->get(); // Eager loading relasi user->get();
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

        $jawabanWarmUp = new JawabWarmUp();
        $jawabanWarmUp->submateri_id = $request->submateri_id;
        $jawabanWarmUp->user_id = Auth::id();
        $jawabanWarmUp->jawaban = $request->jawaban;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
            $jawabanWarmUp->file = $filePath;
        }

        $jawabanWarmUp->save();

        return redirect()->route('subamteri.index', $request->submateri_id)->with('success', 'Jawaban berhasil dikirim!');
    }

    public function show($submateri_id)
    {
        $submateri = SubMateri::findOrFail($submateri_id);
        $jawabanWarmUp = JawabWarmUp::where('submateri_id', $submateri_id)->where('user_id', Auth::id())->first();
        

        return view('jawabanWarmUp.show', compact('submateri', 'jawabanWarmUp'));
}

public function edit($id)
{
    $jawabanWarmUp = JawabWarmUp::findOrFail($id);

    if ($jawabanWarmUp->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    return view('jawabanWarmUp.edit', compact('jawabanWarmUp'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'jawaban' => 'required|string',
        'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,txt,mp4|max:10240',
    ]);

    $jawabanWarmUp = JawabWarmUp::findOrFail($id);

    if ($jawabanWarmUp->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    $jawabanWarmUp->jawaban = $request->jawaban;

    // Handle file replacement
    if ($request->hasFile('file')) {
        $filePath = $request->file('file')->store('uploads','public');
        $jawabanWarmUp->file = $filePath;
    }

    $jawabanWarmUp->save();

    return redirect()->route('jawabanWarmUp.show', $jawabanWarmUp->submateri_id)->with('success', 'Jawaban berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jawabanWarmUp = JawabWarmUp::findOrFail($id);

        if ($jawabanWarmUp->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $jawabanWarmUp->delete();

        return redirect()->route('jawabanWarmUp.index', $jawabanWarmUp->submateri_id)->with('success', 'Jawaban berhasil dihapus!');
    }
}
