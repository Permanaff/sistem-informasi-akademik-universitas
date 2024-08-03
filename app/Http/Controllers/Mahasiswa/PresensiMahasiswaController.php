<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Presensi;
use App\Models\RiwayatAbsen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Support\Str;

class PresensiMahasiswaController extends Controller
{
    private $nim;

    public function __construct()
    {
        $this->nim = Auth::user()->no_induk;
    }

    public function index() : View 
    {
        $data = Krs::with(['detail_krs.jadwal', 'detail_krs.jadwal.matkul', 'detail_krs.jadwal.presensi' => function ($query) {
            $query->where('nim', $this->nim);
        }, 'detail_krs.jadwal.gedungs'])->where('nim', $this->nim)->get();

        

        $kehadiran = $data->map(function ($khdrn) {
            return $khdrn->detail_krs->map(function($items) {
                $hadir = $items->jadwal->presensi->map(function ($ket) {
                    return (object) [
                        'ket' => $ket['ket'],
                        'pertemuan' => $ket['pertemuan']
                    ];
                })->values();


                $currentPertemuanCount = $hadir->count();
                if ($currentPertemuanCount < 14) {
                    for ($i = 1; $i <= 14; $i++) {
                        if (!$hadir->contains('pertemuan', $i)) {
                            $hadir->push((object) [
                                'ket' => '', 
                                'pertemuan' => $i
                            ]);
                        }
                    }
                }
            
                $hadir = $hadir->sortBy('pertemuan')->values();

                $gedung = $items->jadwal->gedungs->gedung.' - '.$items->jadwal->gedungs->no_ruang;
                $jam = Carbon::parse($items->jadwal->jam_mulai)->format('H:i').'-'.Carbon::parse($items->jadwal->jam_selesai)->format('H:i');
                $hari = $items->jadwal->hari;

                return [
                    'id_jadwal' => $items->id,
                    'matkul'    => $items->jadwal->matkul->nama_matkul,
                    'sks'       => $items->jadwal->matkul->sks,
                    'presensi'  => $hadir,
                    'jadwal'    => '('.Str::title($hari).'), '.$jam.' ('.$gedung.')',
                ];
            });
        })->collapse();

        // dd($kehadiran->toArray());

        return view('mahasiswa.kehadiran', compact('kehadiran'));
    }


}