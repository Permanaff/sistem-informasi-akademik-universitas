<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_jadwal', 'pertemuan', 'ket', 'kode_absen', 'batas_mulai', 'batas_selesai'
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class,'id_jadwal','id');
    }

    public function riwayat_jadwal()
    {
        return $this->hasMany(RiwayatAbsen::class,'id_absen');
    }

}
