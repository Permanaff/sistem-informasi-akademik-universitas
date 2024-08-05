<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\DetailKrs;
use App\Models\Jadwal;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Log;

class CetakKrsController extends Controller
{
    private $nim;

    public function __construct()
    {
        $this->nim = Auth::user()->no_induk;
    }

    public function index() 
    {
        $tahun_akademik = TahunAkademik::where('status', 'aktif')->first();

        // $dataKrs = DetailKrs::with('jadwal', 'jadwal.matkul')->whereHas('krs')->whereHas('krs.tahun_akademik', function($query) {$query->where('status', 'aktif');})->get();

        $dataKrs = Krs::with('detail_krs', 'detail_krs.jadwal', 'detail_krs.jadwal.matkul', 'tahun_akademik')->whereHas('tahun_akademik', function($query) use($tahun_akademik) {
            $query->where('tahun_ajaran', $tahun_akademik->tahun_ajaran);
        })->where('nim', $this->nim)->get();

        // dd($dataKrs->toArray());
        $mhs = Mahasiswa::with('prodi', 'prodi.fakultas', 'kelas.dosen')->where('nim', $this->nim)->get();

        
        $mahasiswa = $mhs->map(function ($item) {
            return (object) [
                'nim' => $item->nim,
                'nama' => $item->nama,
                'prodi' => $item->prodi->nama_prodi,
                'jenjang' => $item->prodi->jenjang,
                'fakultas' => $item->prodi->fakultas->nama_fakultas,
                'dosen' => $item->kelas->dosen->nama,
            ];
        });

        $krs = $dataKrs->Map(function ($kr) {
            return $kr->detail_krs->map(function ($detail) {
                return (object) [
                    'kode_mk' => $detail->jadwal->matkul->kode_matkul,
                    'matkul' => $detail->jadwal->matkul->nama_matkul,
                    'sks' => $detail->jadwal->matkul->sks,
                    'kls' => $detail->jadwal->kls,
                ];
            });
        })->collapse();

        $path = public_path('images/logo.png');

        // dd($krs->toArray());

        $filename = 'KRS-'.$this->nim.'.pdf';

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('isFontSubsettingEnabled', true);
        // $options->set('debugPng', true);
        // $options->set('debugKeepTemp', true);
        // $options->set('tempDir', storage_path('temp')); 

        // return view('mahasiswa.cetak', compact('mahasiswa','krs', 'path'));

        $pdf = Pdf::loadView('mahasiswa.cetak', [ 'mahasiswa' => $mahasiswa, 'krs' => $krs, 'path' => $path, 'ta' => $tahun_akademik])->setOptions([$options]);
        return $pdf->download($filename);
    }
}
