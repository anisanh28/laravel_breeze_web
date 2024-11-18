<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabWarmUp extends Model
{
    use HasFactory;

    protected $table = 'jawaban_soal_warm_up'; // Nama tabel
    protected $fillable = [
        'submateri_id', 'user_id', 'jawaban', 'file'
    ];

    // Relasi ke SubMateri
    public function submateri()
    {
        return $this->belongsTo(SubMateri::class, 'submateri_id'); // Relasi berdasarkan foreign key 'submateri_id'
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Relasi berdasarkan foreign key 'user_id'
    }
}
