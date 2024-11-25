<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilEvaluasi extends Model
{
    use HasFactory;
    protected $table = 'hasil_evaluasis';
    protected $fillable = ['user_id','evaluasi_id','skor','waktu_pengerjaan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evaluasi()
    {
        return $this->belongsTo(Evaluasi::class);
    }
}
