<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim', 'id_jadwal', 'status'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class,'nim', 'nim');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class,'id_jadwal', 'id');
    }

    public function khs()
    {
        return $this->hasOne(Khs::class,'id_krs');
    }

    public function presensi() {
        return $this->hasManyThrough(Presensi::class, Jadwal::class, 'id', 'id_jadwal', 'id_jadwal', 'id')
                    ->whereColumn('presensi.nim', 'krs.nim');
    }
}
