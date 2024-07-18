<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index() : View 
    {
        $kelas = Kelas::all();

        return view('admin.kelas', compact('kelas'));
    }
}
