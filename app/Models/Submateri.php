<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submateri extends Model
{
    use HasFactory;
    protected $table = 'submateri';
    protected $fillable = [
        'materi_id', 'judulSubMateri', 'tujuanPembelajaran', 'content', 'file'
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }
}
