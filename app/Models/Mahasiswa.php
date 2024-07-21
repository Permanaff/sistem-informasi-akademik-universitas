<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim', 'nama', 'tempat_lahir', 'tanggal_lahir','alamat', 'id_prodi', 'id_kelas','agama', 'notelp', 'email', 'jk', 'photo'
    ];

    protected $hidden = [
        
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'id_kelas', 'id');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class,'id_prodi', 'id');
    }

    public function riwayat_absen()
    {
        return $this->belongsTo(RiwayatAbsen::class,'id_mahasiswa');
    }

    public function krs()
    {
        return $this->belongsTo(Krs::class,'id_mahasiswa');
    }
}
