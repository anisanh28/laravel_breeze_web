<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaktuAkses extends Model
{
    use HasFactory;
    protected $table = 'waktu_akses';
    protected $fillable = ['user_id','submateri_id','waktu_mulai','waktu_selesai','durasi'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function submateri()
    {
        return $this->belongsTo(Submateri::class, 'submateri_id');
    }
}
