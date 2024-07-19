<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    use HasFactory;

    protected $fillable = [
        'gedung', 'no_ruang'
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class,'id_kelas');
    }
}
