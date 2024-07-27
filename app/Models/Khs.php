<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khs extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim', 'id_krs', 'uts', 'nilai'
    ];

    public function krs()
    {
        return $this->belongsTo(Krs::class,'id', 'id_krs');
    }

}
