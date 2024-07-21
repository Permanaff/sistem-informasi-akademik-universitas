<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nidn', 'nama', 'tempat_lahir', 'alamat', 'agama', 'notelp', 'email', 'jk', 'id_fakultas', 'photo'
    ];

    protected $hidden = [
        
    ];

    // public function users()
    // {
    //     return $this->belongsTo(User::class,'no_induk','nidn');
    // }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class,'id_fakultas','id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class,'id_jadwal');
    }

    public function kelas()
    {
        return $this->hasOne(Jadwal::class,'id_dosen');
    }
}
