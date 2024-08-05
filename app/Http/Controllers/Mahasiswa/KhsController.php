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

use function PHPUnit\Framework\isEmpty;

class KhsController extends Controller
{
    private $nim;

    public function __construct()
    {
        $this->nim = Auth::user()->no_induk;
    }

    public function index() 
    {

        // $dataMatkul = Krs::with( 'detail_krs.khs', 'detail_krs.jadwal.matkul')->where('nim', $this->nim)->get();

        $dataMatkul = Krs::with( 'detail_krs.nilai', 'detail_krs.jadwal.matkul')->where('nim', $this->nim)->get();

        if ($dataMatkul->isEmpty()) {
            $khs = [];
            $totalNilai = 0;
            $ip = 0;
            $totalSks = 0;

            return view('mahasiswa.khs', compact('khs', 'totalSks', 'totalNilai', 'ip'));
        }

        $khs = $dataMatkul->map(function ($item) {
            return $item->detail_krs->map(function ($nilai) {
                $nilai_akhir = $nilai->nilai != null ? $nilai->nilai->nilai : '';
                $bobot = $nilai_akhir == '' ? '' : ($nilai_akhir > 80 ? '4' : ($nilai_akhir > 60 ? '3' : ($nilai_akhir > 40 ? '2' : '1')));
                $total = $bobot == '' ? '' : $nilai->jadwal->matkul->sks * $bobot;
                $uts = $nilai->nilai != null ? ($nilai->nilai->uts == '' ? : $nilai->nilai->uts) : '';
    
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
        })->first();


        $totalSks = $khs->sum('sks');

        $totalNilai = $khs->sum(function($item) {
            return $item['total'] === '' ? 0 : $item['total'] ;
        });

        $totalBobot  = $khs->sum(function($item) {
            return $item['bobot'] === '' ? 0 : $item['sks'] * $item['bobot'];
        });

        $ip = $totalSks > 0 ? $totalBobot / $totalSks : 0;
        $ip = floor($ip) == $ip ? $ip = number_format($ip, 0) :  $ip = number_format($ip, 2);


        // Log::info($khs);

        return view('mahasiswa.khs', compact('khs', 'totalSks', 'totalNilai', 'ip'));
    }
}
