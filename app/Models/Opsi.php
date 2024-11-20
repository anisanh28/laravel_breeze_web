<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opsi extends Model
{
    use HasFactory;
    protected $table='opsis';
    protected $fillable=['pertanyaan_id','opsi','status'];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }
}
