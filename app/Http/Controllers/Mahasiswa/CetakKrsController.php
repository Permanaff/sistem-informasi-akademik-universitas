<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;


class CetakKrsController extends Controller
{
    private $nim;

    public function __construct()
    {
        $this->nim = Auth::user()->no_induk;
    }

    public function index() 
    {
        $dataKrs = Krs::with('jadwal', 'jadwal.matkul')->where('nim', $this->nim)->get();
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

        $krs = $dataKrs->map(function ($kr) {
            return (object) [
                'kode_mk' => $kr->jadwal->matkul->kode_matkul,
                'matkul' => $kr->jadwal->matkul->nama_matkul,
                'sks' => $kr->jadwal->matkul->sks,
                'kls' => $kr->jadwal->kls,
            ];
        });
        // dd($mahasiswa->toArray());
        return view('mahasiswa.cetakkrs', compact('mahasiswa','krs'));
        // $pdf = Pdf::loadView('mahasiswa.cetakkrs', compact('mahasiswa', 'krs'));
        // $pdf->setOption([ 'defaultFont' => 'sans-serif']);;

        // return $pdf->download('invoice.pdf');

    }
}
