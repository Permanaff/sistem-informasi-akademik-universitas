<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKrs extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_krs', 'id_jadwal'
    ];

    public function krs()
    {
        return $this->belongsTo(Krs::class,'id_krs', 'id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal');
    }

    public function khs()
    {
        return $this->hasOne(Khs::class, 'id_detail_krs', 'id');
    }

    public function presensi() {
        return $this->hasManyThrough(Presensi::class, Jadwal::class, 'id', 'id_jadwal', 'id_jadwal', 'id')
                    ->whereColumn('presensi.nim', 'krs.nim');
    }
}
