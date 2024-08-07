<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Jadwal;
use App\Models\RiwayatAbsen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Str;
use LaravelQRCode\Facades\QRCode;

class PresensiController extends Controller
{
    public function index(): View
    {   
        $nidn = Auth::user()->no_induk;
        $jadwals = Jadwal::with('matkul')->where('nidn', $nidn)->get();

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

        // $kode_absen = Str::random(85);
        $kode = $request->matkul.'/'.$request->pertemuan;
        $kode_absen = Crypt::encryptString($kode);

        $decrypted = Crypt::decryptString($kode_absen);


        Absen::create([
            'id_jadwal' => $request->matkul,
            'pertemuan' => $request->pertemuan,
            'ket' => '-',
            'kode_absen' => $kode_absen,
            'batas_mulai' => $request->mulai,
            'batas_selesai' => $request->selesai,
        ]);

        $path = public_path('/images/qr-absen').'/'.$kode_absen.'.png';
        $filename = $kode_absen.'.png';
        QRCode::text($kode_absen)
            ->setSize(10)
            ->setOutfile($path )
            ->png();

        return response()->json([
            'success' => true, 
            'data' => [
                'kode_absen' => $kode_absen,
                'qr_code' => $filename,
            ]
        ]);
    }
}
