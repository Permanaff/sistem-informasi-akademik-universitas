<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun-ajaran', 'semester', 'status'
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class,'id_ta');
    }

    public function ka()
    {
        return $this->hasMany(KalenderAkademik::class,'id_ta');
    }
}
