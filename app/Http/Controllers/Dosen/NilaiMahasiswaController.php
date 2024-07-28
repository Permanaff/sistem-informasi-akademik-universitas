<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

use function PHPSTORM_META\type;

class NilaiMahasiswaController extends Controller
{
    private $nidn;

    public function __construct()
    {
        $this->nidn = Auth::user()->no_induk;
    }

    public function index() : View
    {
        $jadwal = Jadwal::with('matkul')->where('nidn', $this->nidn)->get();

        return view('dosen.nilaimahasiswa', compact('jadwal'));
    }

    // public function daftarMhs()
    // {
    //     $mahasiswa = 'mahasiswa';

    //     $jadwal = Jadwal::with('matkul')->where('nidn', $this->nidn)->get();

    //     return view('dosen.nilaimahasiswa', compact('jadwal'));
    // }

    public function show(Request $request): View 
    {
        $request->validate([
            'kelas' => 'required',
        ]);

        $jadwal = Jadwal::with('matkul')->where('nidn', $this->nidn)->get();

        $id_kelas = $request->kelas;

        $dataMahasiswa = Mahasiswa::whereHas('krs', function ($query) use ($id_kelas) {
            $query->where('id_jadwal', $id_kelas);
        })->with(['krs' => function ($query) use ($id_kelas) {
            $query->where('id_jadwal', $id_kelas);
        }, 'krs.jadwal', 'krs.khs'])->get();

        $mahasiswa = $dataMahasiswa->map(function ($mhs) {
            $nilai_null = [
                    'cmpk1' => '',
                    'cmpk2' => '',
                    'cmpk3' => '',
                    'cmpk4' => '',
                    'uts' => '',
                    'uas' => '',
                    'nilai' => '',
            ];

            
            $khs = $mhs->krs->map(function ($krs) {
                return $krs->khs;
            })->first();

            $nilai = $khs != null ? [
                'cmpk1' => $khs->cpmk1 == null ? '' : $khs->cpmk1 ,
                'cmpk2' => $khs->cpmk2 == null ? '' : $khs->cpmk2,
                'cmpk3' => $khs->cpmk3 == null ? '' : $khs->cpmk3,
                'cmpk4' => $khs->cpmk4 == null ? '' : $khs->cpmk14,
                'uts' => $khs->uts == null ? '' : $khs->uts,
                'uas' => $khs->uas == null ? '' : $khs->uas,
                'nilai' => $khs->nilai == null ? '' : $khs->nilai,
            ] : null;
            // dd($khs->toArray());

            return [
                'nim' =>  $mhs->nim,
                'nama' => $mhs->nama,
                'nilai' => !$khs ? $nilai_null : $nilai,
            ];
        });

        // dd($mahasiswa->toArray());

        // Log::info($dataMahasiswa);
        // foreach ($mahasiswa as $mhs) {
        //     Log::info($mhs);
        //     // Log::info($mhs['nim']);
        //     // Log::info($mhs['nama']);
        //     // Log::info($mhs['nilai']);
        //     // foreach ($mhs['nilai'] as $a) {
        //     //     Log::info($a);
        //     // }
        // }

        return view('dosen.nilaimahasiswa', compact('jadwal', 'mahasiswa'));
    }

}

