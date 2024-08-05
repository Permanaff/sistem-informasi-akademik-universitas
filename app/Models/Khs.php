<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khs extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_krs', 'ips'
    ];

    public function krs()
    {
        return $this->belongsTo(Krs::class,'id_krs', 'id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class,'id_khs', 'id');
    }

}
