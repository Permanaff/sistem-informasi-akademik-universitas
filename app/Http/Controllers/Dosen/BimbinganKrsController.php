<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BimbinganKrsController extends Controller
{
    private $nidn;

    public function __construct()
    {
        $this->nidn = Auth::user()->no_induk;
    }
    public function index() : View
    {
        
        $kelas = Kelas::with('prodi')->where('nidn', $this->nidn)->get(); 

        $mahasiswa = Mahasiswa::whereIn('id_kelas', $kelas->pluck('id'))->get();
        
        return view('dosen.bimbingankrs', compact('kelas', 'mahasiswa'));
    }
}
