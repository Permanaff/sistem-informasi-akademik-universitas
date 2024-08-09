<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Fakultas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DosenController extends Controller
{
    public function index() : View 
    {
        $dosens = Dosen::with('fakultas')->get();
        $fakultas = Fakultas::all();

        return view('admin.dosen', compact('dosens', 'fakultas'));
    }

    public function store(Request $request) : RedirectResponse 
    {  


        $request->validate([
            'nidn' => 'required',
            'fakultas' => 'required',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'agama' => 'required',
            'no_telp' => 'required',
            'email' => 'required|email',
            'jk' => 'required',
        ]);


        Dosen::create([
            'id_fakultas' => $request->fakultas,
            'nidn' => $request->nidn,
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'agama' => $request->agama,
            'notelp' => $request->no_telp,
            'email' => $request->email,
            'jk' => $request->jk,
        ]);

        User::create([
            'no_induk' => $request->nidn,
            'password' => Hash::make(Carbon::parse($request->tanggal_lahir)->format('d-m-Y')),
            'role' => 'dosen',
        ]);

        return redirect()->route('dosen.index')->with(['success' => 'Berhasil Menambahkan Data Dosen']);
    }
}
