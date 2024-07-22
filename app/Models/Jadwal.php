<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_matkul', 'id_kelas', 'id_ta', 'nidn', 'kls', 'hari', 'jam_mulai', 'jam_selesai', 'kuota'
    ];

    public function matkul()
    {
        return $this->belongsTo(Matkul::class,'id_matkul','id');
    }

    public function gedungs()
    {
        return $this->belongsTo(Gedung::class,'id_kelas','id');
    }

    public function tahun_ajar()
    {
        return $this->belongsTo(TahunAjar::class,'id_ta','id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class,'nidn','nidn');
    }

    public function absen()
    {
        return $this->hasMany(Absen::class,'id_jadwal');
    }

    public function krs()
    {
        return $this->hasMany(Krs::class,'id_jadwal');
    }

}
