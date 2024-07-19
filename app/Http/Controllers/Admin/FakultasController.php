<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Fakultas;
use Carbon\Carbon;
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


