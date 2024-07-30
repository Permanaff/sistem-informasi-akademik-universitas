<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khs extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim', 'id_krs', 'uts', 'nilai', 'uas', 'cpmk1', 'cpmk2', 'cpmk3', 'cpmk4'
    ];

    public function krs()
    {
        return $this->belongsTo(Krs::class,'id_krs', 'id');
    }

}
