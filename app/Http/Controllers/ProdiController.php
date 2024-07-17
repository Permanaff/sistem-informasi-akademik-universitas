<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProdiController extends Controller
{
    public function index() : View 
    {
        $prodis = Prodi::with('fakultas')->latest()->paginate(10);
        // Log::info();
        return view('admin.prodi', compact('prodis'));
    }
}
