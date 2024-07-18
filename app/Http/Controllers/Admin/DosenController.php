<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DosenController extends Controller
{
    public function index() : View 
    {
        $dosens = Dosen::with('fakultas')->get();

        return view('admin.dosen', compact('dosens'));
    }
}
