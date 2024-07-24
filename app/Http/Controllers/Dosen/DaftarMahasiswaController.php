<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Krs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class DaftarMahasiswaController extends Controller
{
    private $nidn;

    public function __construct()
    {
        $this->nidn = Auth::user()->no_induk;
    }

    public function index() : View
    {
        $jadwal = Jadwal::with('matkul')->where('nidn', $this->nidn)->get();
        return view('dosen.daftarMahasiswa', compact('jadwal'));
    }

    public function store(Request $request)
    {
        Log::info('---------- store ----------');
        $validator = Validator::make($request->all(), [
            'id_jadwal' => 'required',
        ]);

        Log::info('Id_jadwal: ', ['id_jadwal' => $request->id_jadwal]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else if ($request->id_jadwal == '0') {
            return response()->json($validator->errors(), 422);
        }

        $krs = Krs::with('mahasiswa', 'mahasiswa.kelas.dosen')->where('id_jadwal', $request->id_jadwal)->get();

        $mahasiswa = $krs->map(function ($item) {
            return [
                'nama' => $item->mahasiswa->nama,
                'nim' => $item->mahasiswa->nim,
                'dpa' => $item->mahasiswa->kelas->dosen->nama,
                'jk' => $item->mahasiswa->jk,
                'angkatan' => $item->mahasiswa->angkatan,
            ];
        });

        return response()->json([
            'success' => true, 
            'data' => [
                'mahasiswa' => $mahasiswa,
            ]
        ]);
    }
}
