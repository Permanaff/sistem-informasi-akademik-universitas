<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Matkul;
use App\Models\Prodi;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class MatkulController extends Controller
{
    public function index() : View
    {   
        
        $matkuls = Matkul::with('prodis')->latest()->paginate(10);
        $prodis = Prodi::all();
        
        return view('admin.matkul', compact('matkuls', 'prodis'));
    }

    public function store(Request $request) : RedirectResponse
    { 
        Log::info($request);
        $request->validate([
            'kode_matkul' => 'required',
            'prodi' => 'required',
            'matkul' => 'required',
            'sks' => 'required|integer',
            'smt' => 'required',
        ]);

        Matkul::create([
            'kode_matkul' => $request->kode_matkul,
            'id_prodi' => $request->prodi,
            'nama_matkul' => $request->matkul, 
            'sks' => $request->sks,
            'semester' => $request->smt
        ]);

        return redirect()->route('matkul.index')->with('success', 'Matkul berhasil ditambahkan.');
    }
}


