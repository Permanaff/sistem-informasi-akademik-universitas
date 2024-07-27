<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KhsController extends Controller
{
    public function index() : View
    {
        return view('mahasiswa.khs');
    }
}
