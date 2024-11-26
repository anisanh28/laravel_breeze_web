<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    use HasFactory;
    protected $table= 'pertemuans';
    protected $fillable = ['judul'];

    public function aktifitas()
{
    return $this->hasMany(Aktifita::class);
}
}
