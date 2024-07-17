<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_fakultas',
    ];

    protected $hidden = [
        
    ];

    public function prodi()
    {
        return $this->hasMany(Prodi::class,'id_fakultas');
    }

    // public function dosens()
    // {
    //     return $this->hasMany(Dosen::class,'id_fakultas');
    // }
}
