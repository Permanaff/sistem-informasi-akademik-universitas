<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_khs', 'id_detail_krs', 'nilai', 'cpmk1', 'cpmk2', 'cpmk3', 'cpmk4', 'uts', 'uas'
    ];

    
}
