<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Jadwal;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\RiwayatAbsen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class RiwayatAbsenController extends Controller
{
    private $nidn;

    public function __construct()
    {
        $this->nidn = Auth::user()->no_induk;
    }


    public function index() : View
    {
        $jadwal = Jadwal::with('matkul')->where('nidn', $this->nidn)->get();

        return view('dosen.riwayatAbsen', compact('jadwal'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_jadwal' => 'required',
        ]);

        // Validasi data 
        if ($validator->fails() or $request->id_jadwal == '0') {
            return response()->json($validator->errors(), 422);
        } 


        $absen = Krs::with(['mahasiswa' => function($query) {
            $query->orderBy('nim', 'asc');
        }, 'mahasiswa.riwayat_absen' => function($query) {
            $query->orderBy('pertemuan', 'asc');
        }])
        ->where('id_jadwal', $request->id_jadwal)
        ->get();
        
        // Prepare the grouped data
        $groupedData = [];
        
        foreach ($absen as $index => $item) {
            $mahasiswa = $item->mahasiswa;
            $nim = $mahasiswa->nim;
        
            if (!isset($groupedData[$nim])) {
                $groupedData[] = [
                    'nim' => $nim,
                    'nama' => $mahasiswa->nama,
                    'riwayat_absen' => []
                ];

                for ($i = 1; $i <= 14; $i++) {
                    $groupedData[$index]['riwayat_absen'][$i] = [
                        'pertemuan' => $i,
                        'ket' => ''
                    ];
                }
            }

            foreach ($mahasiswa->riwayat_absen as $absen) {
                $pertemuan = $absen->pertemuan;
                if (isset($groupedData[$index]['riwayat_absen'][$pertemuan])) {
                    $groupedData[$index]['riwayat_absen'][$pertemuan]['ket'] = $absen->ket;
                }
            }
        }

        return response()->json([
            'success' => true, 
            'data' => [
                'mahasiswa' => $groupedData,
            ]
        ]);
    }

    public function daftarMahasiswa(Request $request) 
    {
        $request->validate([
            'id_jadwal' => 'required',
        ]);

        $id_jadwal = $request->id_jadwal;


        $jadwal = Jadwal::with('matkul')->where('nidn', $this->nidn)->get();

        // $absen = Mahasiswa::whereHas('krs', function($query) use($id_jadwal) {
        //     $query->where('id_jadwal', $id_jadwal);
        // })->with('krs.jadwal.presensi')->get();

        // $absen = Mahasiswa::whereHas('krs', function($query) use($id_jadwal) {
        //     $query->where('id_jadwal', $id_jadwal);
        // })
        // ->with(['krs' => function($query) use($id_jadwal) {
        //     $query->where('id_jadwal', $id_jadwal)
        //           ->with(['jadwal.presensi']);
        // }])
        // ->get();

        // $absen = Krs::with(['mahasiswa', 'mahasiswa.presensi' => function ($query) use($id_jadwal) {
        //     $query->where('id_jadwal', $id_jadwal);
        // }, 'jadwal.gedungs'])->where('id_jadwal', $id_jadwal)->get();

        $absen = Krs::with(['mahasiswa', 'mahasiswa.presensi'])->where('id_jadwal', $id_jadwal)->get();

        $dataAbsen = $absen->map(function($item) {
            $hadir = $item->mahasiswa->presensi->map(function($presensi) {
                    return (object) [
                        'pertemuan' => $presensi->pertemuan,
                        'ket' => $presensi->ket,
                    ];
                });

            for ($i = 1; $i <= 14; $i++) {
                if (!$hadir->contains('pertemuan', $i)) {
                    $hadir->push((object) [
                        'pertemuan' => $i,
                        'ket' => '',
                    ]);
                }
            }

            $hadir = $hadir->sortBy('pertemuan')->values();

            return (object) [
                'nama' => $item->mahasiswa->nama,
                'nim' => $item->mahasiswa->nim,
                'presensi' => $hadir,
            ];
        });

        // dd($dataAbsen->toArray());
        // dd($absen->toArray());

        return view('dosen.riwayatAbsen', compact('jadwal', 'dataAbsen'));
    }
}
