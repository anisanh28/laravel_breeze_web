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
        $evaluasi = Evaluasi::all();
        return view('pertanyaan.create',compact('pertanyaan','evaluasi_id'));
    }

    public function store(Request $request, $evaluasi_id){
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'file'=>'required|file|mimes:png,jpg,jpeg,mp3,mp4,mov|max:10240',
            'skor'=>'required|integer|max:255',
        ]);

        if($request->hasFile('file')){
            $filePath = $request->file('file')->store('uploads','public');
        }
        Pertanyaan::create([
            'evaluasi_id' => $evaluasi_id,
            'pertanyaan' => $request->input('pertanyaan'),
            'file' => $filePath?? null,
            'skor' => $request->input('skor'),
        ]);
        return redirect()->route('pertanyaan.index',compact('evaluasi_id'))->with('success','Pertanyaan berhasi ditambahkan');
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
