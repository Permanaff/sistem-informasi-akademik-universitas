<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Krs;
use App\Models\Presensi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ScanPresensiController extends Controller
{
    
    private $nim;

    public function __construct()
    {
        $this->nim = Auth::user()->no_induk;
    }

    public function index() : View
    {
        return view('mahasiswa.scanpresensi');
    }

    public function store (Request $request) : RedirectResponse
    {
        $request->validate([
            'kode_absen' => 'required',
        ]);

        $kodeAbsen = Absen::where('kode_absen', $request->kode_absen)->first();

        Log::info($kodeAbsen);
        
        $validateKrs = Krs::where('id_jadwal', $kodeAbsen->id_jadwal)->where('nim', $this->nim)->first();   

        $validateDuplicate = Presensi::where('nim', $this->nim)->where('id_jadwal', $kodeAbsen->id_jadwal)->where('pertemuan', $kodeAbsen->pertemuan)->first();

        Log::info($validateKrs);
        Log::info($validateDuplicate);
        
        if ($validateDuplicate) {
            return redirect()->route('scanabsen.index')->with(['error' => 'Sudah Melakukan Presensi!']);
        }

        if ($kodeAbsen) {
            
            if ($kodeAbsen->batas_mulai > now())
            {
                $message = ['error' => 'Bukan Waktu Presensi!'];
            } 
            else if ($kodeAbsen->batas_selesai < now()) 
            {
                $message = ['error' => 'Melewati Waktu Presensi!'];
            }
            else if (!$validateKrs) {
                $message = ['error' => 'Kode Presensi tidak valid!'];
            } else {
                Presensi::create([
                    'id_jadwal' => $kodeAbsen->id_jadwal,
                    'nim'       => $this->nim,
                    'pertemuan' => $kodeAbsen->pertemuan,
                    'ket'       => 'H',
                ]);
                $message = ['success' => 'Berhasil Presensi!'];
            }

        } else 
        {
            $message = ['error' => 'Kode Presensi tidak valid!'];
        }

        
        return redirect()->route('scanabsen.index')->with($message);
    }
}

