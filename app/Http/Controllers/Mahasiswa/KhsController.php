<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\DetailKrs;
use App\Models\Krs;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class KhsController extends Controller
{
    private $nim;

    public function __construct()
    {
        $this->nim = Auth::user()->no_induk;
    }

    public function index() 
    {
        // $dataMahasiswa = Mahasiswa::whereHas('krs', function ($query) use ($id_kelas) {
        //     $query->where('id_jadwal', $id_kelas);
        // })->with(['krs' => function ($query) use ($id_kelas) {
        //     $query->where('id_jadwal', $id_kelas);
        // }, 'krs.jadwal', 'krs.khs'])->get();

        $dataMatkul = Krs::with( 'detail_krs.khs', 'detail_krs.jadwal.matkul')->where('nim', $this->nim)->get();

        

        $khs = $dataMatkul->map(function ($item) {
            return $item->detail_krs->map(function ($nilai) {
                $nilai_akhir = $nilai->khs != null ? $nilai->khs->nilai : '';
                $bobot = $nilai_akhir == '' ? '' : ($nilai_akhir > 80 ? '4' : ($nilai_akhir > 60 ? '3' : ($nilai_akhir > 40 ? '2' : '1')));
                $total = $bobot == '' ? '' : $nilai->jadwal->matkul->sks * $bobot;
                $uts = $nilai->khs != null ? ($nilai->khs->uts == '' ? : $nilai->khs->uts) : '';
    
                return [
                    'kode_mk' => $nilai->jadwal->matkul->kode_matkul,
                    'matkul' => $nilai->jadwal->matkul->nama_matkul,
                    'sks' => $nilai->jadwal->matkul->sks,
                    'smt' => $nilai->jadwal->matkul->semester,
                    'kelas' => $nilai->jadwal->kls,
                    'uts' => $uts,
                    'nilai' => $nilai_akhir == '' ? '' : ($nilai_akhir > 80 ? 'A' : ($nilai_akhir > 60 ? 'B' : ($nilai_akhir > 40 ? 'C' : ($nilai_akhir > 20 ? 'D' : 'E')))),
                    'bobot' => $bobot,
                    'total' => $total,
                ];
            });
        })->collapse();

        // dd($khs->toArray());

        $totalSks = $khs->sum('sks');
        // $totalNilai = $khs->sum('total');
        $totalNilai = $khs->sum(function($item) {
            return $item['total'] === '' ? 0 : $item['total'] ;
        });

        $totalBobot  = $khs->sum(function($item) {
            return $item['bobot'] === '' ? 0 : $item['sks'] * $item['bobot'];
        });

        $ip = $totalSks > 0 ? $totalBobot / $totalSks : 0;

        // foreach ($dataMatkul as $matkul) {
        //     Log::info($matkul);
        // }


        // Log::info($khs);

        return view('mahasiswa.khs', compact('khs', 'totalSks', 'totalNilai', 'ip'));
    }
}
