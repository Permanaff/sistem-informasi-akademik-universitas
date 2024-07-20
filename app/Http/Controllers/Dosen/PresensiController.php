<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Jadwal;
use App\Models\RiwayatAbsen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Str;

class PresensiController extends Controller
{
    public function index(): View
    {
        $jadwals = Jadwal::with('matkul')->get();

        return view('dosen.presensi', compact('jadwals'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'matkul' => 'required',
            'pertemuan'     => 'required',
            'mulai'   => 'required',
            'selesai'   => 'required',
        ]);


        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kode_absen = Str::random(85);

        Absen::create([
            'id_jadwal' => $request->matkul,
            'pertemuan' => $request->pertemuan,
            'ket' => $request->matkul,
            'kode_absen' => $kode_absen,
            'batas_mulai' => $request->mulai,
            'batas_selesai' => $request->selesai,
        ]);

        return response()->json([
            'success' => true, 
            'data' => [
                'kode_absen' => $kode_absen
            ]
        ]);
    }
}
