<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gedung;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GedungController extends Controller
{
    public function index() : View 
    {
        $kelas = Gedung::all();

        return view('admin.kelas', compact('kelas'));
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'gedung' => 'required',
            'kelas' => 'required'
        ]);

        Gedung::create([
            'gedung' => $request->gedung,
            'no_kelas' => $request->kelas
        ]);

        return redirect()->route('kelas.index')->with(['success' => 'Kelas Berhasil Ditambahkan!']);
    }
}
