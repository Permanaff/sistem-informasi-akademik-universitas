<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeMahasiswaController extends Controller
{
    public function index() : View 
    {
        return view('mahasiswa.home');
    }
}

