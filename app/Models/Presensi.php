<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id_jadwal', 'nim', 'pertemuan', 'ket'
    ];

    
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class,'nim','nim');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id', 'id_jadwal');
    }
}
