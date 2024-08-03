<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khs extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim', 'id_detail_krs', 'uts', 'nilai', 'uas', 'cpmk1', 'cpmk2', 'cpmk3', 'cpmk4'
    ];

    public function detail_krs()
    {
        return $this->belongsTo(DetailKrs::class,'id_detail_krs', 'id');
    }

}
