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

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class,'id_fakultas','id');
    }
}
