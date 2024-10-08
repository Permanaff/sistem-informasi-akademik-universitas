<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatAbsen extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_absen', 'nim', 'pertemuan', 'ket'
    ];

    
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class,'nim','nim');
    }

    public function absen()
    {
        return $this->belongsTo(Absen::class, 'id_absen', 'id');
    }
}
