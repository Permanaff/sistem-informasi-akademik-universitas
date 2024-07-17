<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class FakultasController extends Controller
{
    public function index() : View 
    {
        $fakultas = Fakultas::paginate(10);

        return view('admin.fakultas', compact('fakultas'));
    }

    public function store(Request $request): RedirectResponse
    {
        Log::debug($request->nama_fakultas);
        // Validasi 
        $request->validate([
            'nama_fakultas' => 'required'
        ]);


        // Simpan atau Create Fakultas
        Fakultas::create([
            'nama_fakultas' => $request->nama_fakultas
        ]);

        return redirect('adm/fakultas')->with(['success' => 'Fakultas Berhasil Ditambahkan!']);
    }
}


