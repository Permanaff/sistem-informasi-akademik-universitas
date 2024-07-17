<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode', 'matkul', 'sks', 'kategori', 'smt', 'semester', 'id_prodi'
    ];

    protected $hidden = [
        
    ];

    public function prodis()
    {
        return $this->belongsTo(Prodi::class);
    }

    // public function schedules()
    // {
    //     return $this->hasMany(Schedule::class,'id_matkul');
    // }
}
