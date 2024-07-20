<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function index() : View 
    {
        $mahasiswa = Mahasiswa::with('kelas', 'prodi')->get();

        return view('admin.mahasiswa', compact('mahasiswa'));
    }
}
