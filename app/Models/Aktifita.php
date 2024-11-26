<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktifita extends Model
{
    use HasFactory;
    protected $table = 'aktifitas';
    protected $fillable = [
        'pertemuan_id', 'judulAktifitas', 'deskripsi', 'file','intruksi'
    ];
    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class);
    }
}
