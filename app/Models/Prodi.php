<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_fakultas', 'kode_prodi', 'nama_prodi', 'ka_prodi', 'jenjang'
    ];

    protected $hidden = [
        
    ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class,'id_fakultas','id');
    }

    // public function dosen()
    // {
    // 	return $this->belongsTo(Dosen::class,'ka_prodi');
    // }

    public function matkuls()
    {
        return $this->hasMany(Matkul::class,'id_prodi');
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class,'id_prodi');
    }
}
