<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_mahasiswa', 'id_jadwal'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class,'id_mahasiswa', 'id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class,'id_jadwal', 'id');
    }
}
