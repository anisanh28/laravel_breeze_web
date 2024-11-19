<?php

namespace App\Http\Controllers;
use App\Models\Pertanyaan;
use App\Models\Opsi;
use Illuminate\Http\Request;

class OpsiController extends Controller
{
    public function index(Request $request,$pertanyaan_id){
        if ($pertanyaan_id) {
            $opsi = Opsi::where('pertanyaan_id', $pertanyaan_id)->get();
            $pertanyaan = Pertanyaan::find($pertanyaan_id);
        } else {
            $opsi = Opsi::all();
            $pertanyaan = null;
        }
    }

    public function create($evaluasi_id){
    return view('opsi.create', ['evaluasi_id' => $evaluasi_id]);
    }


    public function store(Request $request, $pertanyaan_id){
        $request->validate([
            'opsi' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        Opsi::create([
            'pertanyaan_id' => $pertanyaan_id,
            'opsi' => $request->opsi,
            'status' => $request->status,
        ]);
        return redirect()->route('opsi.index',compact('pertanyaan_id'))->with('success','Opsi berhasil ditambahkan');
    }
}
