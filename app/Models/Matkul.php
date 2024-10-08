<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_matkul', 'id_prodi', 'nama_matkul', 'sks', 'semester', 'smt'
    ];

    protected $hidden = [
        
    ];

    public function prodis()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class,'id_matkul');
    }
}
