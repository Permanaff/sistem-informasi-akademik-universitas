<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatAbsen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim', 'pertemuan', 'ket'
    ];

    
    
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class,'nim','nim');
    }
}
