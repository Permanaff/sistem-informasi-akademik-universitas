<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\DetailKrs;
use App\Models\Jadwal;
use App\Models\Krs;
use App\Models\Mahasiswa;
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

        // $dataKrs = DetailKrs::with('jadwal', 'jadwal.matkul')->whereHas('krs')->whereHas('krs.tahun_akademik', function($query) {$query->where('status', 'aktif');})->get();

        $dataKrs = Krs::with('detail_krs', 'detail_krs.jadwal', 'detail_krs.jadwal.matkul')->where('nim', $this->nim)->get();

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

        // $path = public_path('images/logo.png');

        // dd($krs->toArray());

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('isFontSubsettingEnabled', true);
        // $options->set('debugPng', true);
        // $options->set('debugKeepTemp', true);
        // $options->set('tempDir', storage_path('temp')); 

        return view('mahasiswa.cetak', compact('mahasiswa','krs'));

        // $pdf = Pdf::loadView('mahasiswa.cetak', [ 'mahasiswa' => $mahasiswa, 'krs' => $krs])->setOptions([$options]);
        // return $pdf->download('krs.pdf');
    }
}
