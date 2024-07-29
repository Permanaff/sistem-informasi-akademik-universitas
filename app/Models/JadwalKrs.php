<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKrs extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_ta', 'id_fakultas', 'tgl_mulai', 'tgl_selesai'
    ];

    public function tahun_akademik()
    {
        return $this->belongsTo(TahunAkademik::class,'id_ta','id');
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class,'id_fakultas','id');
    }
}
