<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProdiController extends Controller
{
    public function index() : View 
    {
        $prodis = Prodi::with('fakultas')->latest()->paginate(10);
        log::info($prodis);
        $fakultas = Fakultas::all();
        return view('admin.prodi', compact('prodis', 'fakultas'));
    }

    public function store(Request $request): RedirectResponse
    {   
        Log::info($request);
        Log::info(intval($request->id_fakultas));
        // Validasi data request 
        try {
            $request->validate([
                'kode_prodi' => 'required',
                'id_fakultas' => 'required|integer',
                'nama_prodi' => 'required',
                'ka_prodi' => 'required',
                'jenjang' => 'required',
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation failed: ', $e->errors());
        }

        
       

    
        // Simpan Data
        Prodi::create([
            'kode_prodi' => $request->kode_prodi,
            'nama_prodi' => $request->nama_prodi,
            'id_fakultas' => intval($request->fakultas),
            'ka_prodi' => $request->ka_prodi,
            'jenjang' => $request->jenjang,
        ]);

        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil ditambahkan.');

    }
}
