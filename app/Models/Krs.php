<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim', 'id_ta','status'
    ];

    public function detail_krs()
    {
        return $this->hasMany(DetailKrs::class,'id_krs', 'id');
    }

    public function khs()
    {
        return $this->hasOne(DetailKrs::class,'id_krs', 'id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class,'nim', 'nim');
    }

    public function tahun_akademik()
    {
        return $this->belongsTo(TahunAkademik::class,'id_ta', 'id');
    }

}
