<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\DetailKrs;
use App\Models\Gedung;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Matkul;
use App\Models\TahunAkademik;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BimbinganKrsController extends Controller
{
    private $nidn;

    public function __construct()
    {
        $this->nidn = Auth::user()->no_induk;
    }
    public function index() : View
    {
        
        $kelas = Kelas::with('prodi')->where('nidn', $this->nidn)->get(); 

        $data = Mahasiswa::whereIn('id_kelas', $kelas->pluck('id'))->with('krs.detail_krs.jadwal.matkul')->get();
        
        $mahasiswa = $data->map(function($mhs) {
            return (object) [
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'status_krs' => $mhs->krs->isNotEmpty() ? ($mhs->krs->first()->status == 'belum-acc' ? 'menunggu acc' : $mhs->krs->first()->status) : 'Tidak ada KRS',
                'sks_diambil' => $mhs->krs->flatMap(function($krs) {
                    return $krs->detail_krs->map(function($detail) {
                        return $detail->jadwal->matkul->sks;
                    });
                })->sum()
            ];
        });

        // dd($mahasiswa->toArray());


        // dd($data->toArray());
        return view('dosen.bimbinganKrs.bimbingankrs', compact('kelas', 'mahasiswa'));
    }

    public function show(string $nim): View 
    {
        $krs = DetailKrs::with('krs','jadwal', 'jadwal.matkul', 'jadwal.tahun_akademik', 'jadwal.gedungs')->whereHas('krs', function($query) use($nim) {
            $query->where('nim', $nim);
        })->get();

        return view('dosen.bimbinganKrs.krsMahasiswa', compact('krs'));
    }

    public function daftarMatkul() : View
    {
        $smt = TahunAkademik::where('status', 'aktif')->value('semester');

        $jadwals = Jadwal::with('matkul', 'gedungs', 'tahun_akademik', 'dosen')->whereHas('matkul', function($query) use($smt) {
            $query->where('smt', $smt);
        })->latest()->get();

        foreach ($jadwals as $jadwal) {
            $jadwal->formatted_jam_mulai = Carbon::parse($jadwal->jam_mulai)->format('H:i');
            $jadwal->formatted_jam_selesai = Carbon::parse($jadwal->jam_selesai)->format('H:i');
        }
        $matkuls = Matkul::all();
        $kelas = Gedung::all();
        
        return view('dosen.bimbinganKrs.daftarMatkul', compact('jadwals', 'matkuls', 'kelas'));
    }

    public function deletekrs($id_krs) 
    {
        $krs = DetailKrs::with('krs.mahasiswa')->findOrFail($id_krs);
        $jadwal = Jadwal::findOrFail($krs->id_jadwal);

        $jadwal->update([
            'kuota' => $jadwal->kuota + 1
        ]);

        $krs->delete();

        return redirect()->route('bimbingankrs.show', $krs->krs->mahasiswa->nim)->with('success', 'KRS berhasil Dihapus.'); 
    }
}
