<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\DetailKrs;
use App\Models\Jadwal;
use App\Models\Khs;
use App\Models\Krs;
use App\Models\Mahasiswa;
use Illuminate\Contracts\View\View as ViewView;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;


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
            $query->whereHas('detail_krs', function($query) use ($id_kelas) {$query->where('id_jadwal', $id_kelas);});
        })->with(['krs.detail_krs' => function ($query) use ($id_kelas) {
            $query->where('id_jadwal', $id_kelas);
        }, 'krs.detail_krs.jadwal', 'krs.detail_krs.khs'])->get();

        // dd($dataMahasiswa->toArray());

        $mahasiswa = $dataMahasiswa->map(function ($mhs) {
            $nilai_null = (object) [
                    'cpmk1' => '',
                    'cpmk2' => '',
                    'cpmk3' => '',
                    'cpmk4' => '',
                    'uts' => '',
                    'uas' => '',
                    'nilai' => '',
            ];

            
            $khs = $mhs->krs->map(function ($krs) {
                return $krs->detail_krs->map(function ($item) {
                    return $item->khs;
                })->first();
            })->first();

            // dd($khs->toArray());

            $nilai = $khs != null ? (object) [
                'cpmk1' => $khs->cpmk1 == null ? '' : $khs->cpmk1 ,
                'cpmk2' => $khs->cpmk2 == null ? '' : $khs->cpmk2,
                'cpmk3' => $khs->cpmk3 == null ? '' : $khs->cpmk3,
                'cpmk4' => $khs->cpmk4 == null ? '' : $khs->cpmk14,
                'uts' => $khs->uts == null ? '' : $khs->uts,
                'uas' => $khs->uas == null ? '' : $khs->uas,
                'nilai' => $khs->nilai == null ? '' : $khs->nilai,
            ] : null;
            // dd($khs->toArray());

            return (object) [
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

        session(['id_kelas' => $id_kelas]);

        return view('dosen.nilaimahasiswa', compact('jadwal', 'mahasiswa', 'id_kelas'));
    }

    public function inputPage(Request $request) : View
    {
        $request->validate([
            'id_kelas' => 'required'
        ]);

        $id_kelas = $request->id_kelas;

        $dataMahasiswa = Mahasiswa::whereHas('krs', function ($query) use ($id_kelas) {
            $query->whereHas('detail_krs', function($query) use ($id_kelas) {$query->where('id_jadwal', $id_kelas);});
        })->with(['krs.detail_krs' => function ($query) use ($id_kelas) {
            $query->where('id_jadwal', $id_kelas);
        }, 'krs.detail_krs.jadwal', 'krs.detail_krs.khs'])->get();

        // dd($dataMahasiswa);

        $mahasiswa = $dataMahasiswa->map(function ($mhs) {
            $nilai_null = (object) [
                    'cpmk1' => '',
                    'cpmk2' => '',
                    'cpmk3' => '',
                    'cpmk4' => '',
                    'uts' => '',
                    'uas' => '',
                    'nilai' => '',
            ];

            
            $khs = $mhs->krs->map(function ($krs) {
                return $krs->detail_krs->map(function ($item) {
                    return $item->khs;
                })->first();
            })->first();

            $nilai = $khs != null ? (object) [
                'cpmk1' => $khs->cpmk1 == null ? '' : $khs->cpmk1 ,
                'cpmk2' => $khs->cpmk2 == null ? '' : $khs->cpmk2,
                'cpmk3' => $khs->cpmk3 == null ? '' : $khs->cpmk3,
                'cpmk4' => $khs->cpmk4 == null ? '' : $khs->cpmk14,
                'uts' => $khs->uts == null ? '' : $khs->uts,
                'uas' => $khs->uas == null ? '' : $khs->uas,
                'nilai' => $khs->nilai == null ? '' : $khs->nilai,
            ] : null;
            // dd($khs->toArray());

            return (object) [
                'nim' =>  $mhs->nim,
                'nama' => $mhs->nama,
                'nilai' => !$khs ? $nilai_null : $nilai,
            ];
        });
        
        return view('dosen.nilaiMhs.inputnilai', compact('mahasiswa'));
    }

    public function inputNilai(Request $request) : RedirectResponse
    {
        $request->validate([
            'nilai.*.nim' => 'required',
            'nilai.*.cpmk1' => 'nullable|integer',
            'nilai.*.cpmk2' => 'nullable|integer',
            'nilai.*.cpmk3' => 'nullable|integer',
            'nilai.*.cpmk4' => 'nullable|integer',
            'nilai.*.uts' => 'nullable|integer',
            'nilai.*.uas' => 'nullable|integer',
            'nilai.*.total' => 'nullable|integer',
        ]);

        $id_jadwal = session('id_kelas');

        foreach ($request->nilai as $data) {

            try {
                // dd('inputNilai');
                // Mencari entri khs yang ada

                // $checkKhs = Khs::whereHas('detail_krs', function ($query) use($data, $id_jadwal) {
                //     $query->where('nim', $data['nim'])->where('id_jadwal', $id_jadwal);
                // })->get();

                $checkKhs = Khs::whereHas('detail_krs', function ($query) use($data, $id_jadwal) {
                    $query->whereHas('krs',function ($query) use($data) {$query->where('nim', $data['nim']);})->where('id_jadwal', $id_jadwal);
                })->firstOrFail();

                // dd($checkKhs->toArray());
                
                // Jika ditemukan, update data
                $checkKhs->update([
                    'cpmk1'  => $data['cpmk1'], 
                    'cpmk2'  => $data['cpmk2'], 
                    'cpmk3'  => $data['cpmk3'], 
                    'cpmk4'  => $data['cpmk4'], 
                    'uts'  => $data['uts'], 
                    'uas'  => $data['uas'], 
                    'nilai'  => $data['total'], 
                ]);

            } catch (ModelNotFoundException $e) {

                $nim = $data['nim'];

                $id_krs = DetailKrs::whereHas('krs', function ($query) use($nim) {
                    $query->where('nim', $nim);
                })->where('id_jadwal', $id_jadwal)->value('id');

                // dd($id_krs);

                // Jika tidak ditemukan, buat entri baru
                Khs::create([
                    'id_detail_krs' => $id_krs,
                    'cpmk1'  => $data['cpmk1'], 
                    'cpmk2'  => $data['cpmk2'], 
                    'cpmk3'  => $data['cpmk3'], 
                    'cpmk4'  => $data['cpmk4'], 
                    'uts'  => $data['uts'], 
                    'uas'  => $data['uas'], 
                    'nilai'  => $data['total'],  
                ]);
            }
        }

        $request->session()->forget('id_kelas');

        return redirect()->route('nilaimahasiswa.index')->with('success', 'Berhasil Input Nilai!');
    }

}

