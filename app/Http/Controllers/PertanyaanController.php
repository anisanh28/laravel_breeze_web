<?php

namespace App\Http\Controllers;
use App\Models\Evaluasi;
use App\Models\Pertanyaan;
use App\Models\Opsi;
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
    // Validasi input
    $validated = $request->validate([
        'pertanyaan' => 'required|string',
        'skor' => 'required|integer',
        'file' => 'nullable|file|mimes:jpeg,png,pdf,docx,doc|max:10240', // Contoh validasi file
        'opsi' => 'required|array',
        'status' => 'required|array',
        'opsi.*' => 'required|string',
        'status.*' => 'required|in:0,1', // Memastikan status hanya 0 atau 1
    ]);

    // Simpan pertanyaan
    $pertanyaan = new Pertanyaan();
    $pertanyaan->pertanyaan = $request->pertanyaan;
    $pertanyaan->skor = $request->skor;
    $pertanyaan->evaluasi_id = $evaluasi_id;

    // Menangani upload file jika ada
    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('uploads', 'public');
        $pertanyaan->file_path = $path;
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

    // Redirect atau response sesuai kebutuhan
    return redirect()->route('pertanyaan.index', $evaluasi_id)->with('success', 'Pertanyaan berhasil ditambahkan');
}

    public function show(Evaluasi $evaluasi)
    {
        $pertanyaan = Pertanyaan::where('evaluasi_id', $evaluasi->id)->get();
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
