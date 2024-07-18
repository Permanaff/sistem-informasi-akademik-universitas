<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeDosenController extends Controller
{
    public function index(): View
    {
        return view('dosen.home');
    }
}
