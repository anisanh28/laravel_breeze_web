<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanEvaluasi extends Model
{
    use HasFactory;
    protected $table='jawaban_evaluasis';
    protected $fillable=['hasilEvaluasi_id','pertanyaan_id','jawaban','status'];

    public function hasilEvaluasi()
    {
        return $this->belongsTo(HasilEvaluasi::class, 'hasil_evaluasi_id');  // Relasi ke model HasilEvaluasi
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');  // Relasi ke model Pertanyaan
    }

    public function getPertanyaanTextAttribute()
    {
        return $this->pertanyaan->pertanyaan ?? '';  // Mengambil teks pertanyaan
    }

    public function getJawabanStatusAttribute()
    {
        return $this->status ? 'Benar' : 'Salah';  // Menampilkan status jawaban (benar/salah)
    }
}
