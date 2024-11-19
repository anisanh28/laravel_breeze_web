<?php

namespace App\Http\Controllers;
use App\Models\Evaluasi;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PertanyaanController extends Controller
{
    public function index(Request $request, $evaluasi_id){
        if($evaluasi_id){
            $pertanyaan = Pertanyaan::where('evaluasi_id', $evaluasi_id)->get();
            $evaluasi = Evaluasi::find($evaluasi_id);
        }else{
            $pertanyaan = Pertanyaan::all();
            $evaluasi = null;
        }
        return view('pertanyaan.index', compact('pertanyaan', 'evaluasi','evaluasi_id'));
    }

    public function create($evaluasi_id){

        $evaluasi = Evaluasi::findOrFail($evaluasi_id);

        return view('pertanyaan.create',compact('evaluasi'));
    }

    public function store(Request $request, $evaluasi_id)
    {
    $request->validate([
        'pertanyaan' => 'required|string',
        'opsi' => 'required|array|min:2', // Minimum 2 opsi
        'opsi.*' => 'required|string|max:255',
        'jawaban_benar' => 'required|integer|min:1',
    ]);

    // Simpan pertanyaan
    $pertanyaan = new Pertanyaan();
    $pertanyaan->evaluasi_id = $evaluasi_id;
    $pertanyaan->pertanyaan = $request->pertanyaan;
    $pertanyaan->save();

    // Simpan opsi
    foreach ($request->opsi as $index => $opsiText) {
        $pertanyaan->opsi()->create([
            'opsi' => $opsiText,
            'is_benar' => ($index + 1 == $request->jawaban_benar) ? true : false,
        ]);
    }

    return redirect()->route('evaluasi.show', $evaluasi_id)->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function show(Evaluasi $evaluasi, Pertanyaan $pertanyaan){

        return view('pertanyaan.show', compact('evaluasi', 'pertanyaan'));
    }

    public function edit($id){
        $pertanyaan = Pertanyaan::findOrFail($id);
        $evaluasi = Evaluasi::all();
        return view('pertanyaan.edit',compact('pertanyaan','evaluasi'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'file'=>'required|file|mimes:png,jpg,jpeg,mp3,mp4,mov|max:10240',
            'skor'=>'required|integer|max:255',
        ]);

        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->pertanyaan=$request->pertanyaan;
        $pertanyaan->skor=$request->skor;

        if($request->hasFile('file')){
            $filePath = $request->file('file')->store('uploads','public');
            $pertanyaan->file = $filePath;
        }

        $pertanyaan->save();

        return redirect()->route('pertanyaan.index',['evaluasi_id'=>$pertanyaan->evaluasi_id])->with('success','Pertanyaan berhasil diperbarui');
    }

    public function destroy ($id){
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->delete();
        return redirect()->route('pertanyaan.index',['evaluasi_id'=>$pertanyaan->evaluasi_id])->with('success','Pertanyaan berhasil dihapus');
    }
}
