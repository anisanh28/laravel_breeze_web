<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table= 'pertanyaan';
    protected $fillable = ['evaluasi_id','pertanyaan','file','skor'];

    public function evaluasi(){
        return $this->belongsTo(Evaluasi::class);
    }
}
