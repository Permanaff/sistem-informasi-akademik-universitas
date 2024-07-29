<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KalenderAkademik extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_ta', 'minggu', 'tgl_mulai', 'tgl_selesai'
    ];

    

    public function tahun_akademik()
    {
        return $this->belongsTo(TahunAkademik::class,'id','id_ta');
    }
}
