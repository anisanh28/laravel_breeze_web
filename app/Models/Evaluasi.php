<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    use HasFactory;
    protected $tabel='evaluasis';
    protected $fillable =['judul_evaluasi','deskripsi_evaluasi','start_time','end_time','durasi'];

    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class);
    }
}

