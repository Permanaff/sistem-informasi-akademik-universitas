<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'id_dosen', 'id_prodi', 'angkatan'
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class,'id_dosen', 'id');
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class,'id_kelas');
    }
}
