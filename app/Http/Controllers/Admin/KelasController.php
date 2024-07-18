<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Kelas;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index() : View 
    {
        $kelas = Kelas::all();

        return view('admin.kelas', compact('kelas'));
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'gedung' => 'required',
            'kelas' => 'required'
        ]);

        Kelas::create([
            'gedung' => $request->gedung,
            'no_kelas' => $request->kelas
        ]);

        return redirect()->route('kelas.index')->with(['success' => 'Kelas Berhasil Ditambahkan!']);
    }
}
