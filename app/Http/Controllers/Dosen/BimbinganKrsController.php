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
use Illuminate\Support\Facades\Log;
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
                'id_krs' => $mhs->krs->isNotEmpty() ? $mhs->krs->first()->id : null,
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

        return view('dosen.bimbinganKrs.krsMahasiswa', compact('krs', 'nim'));
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

    public function tambahkrs($nim) : View
    {
        $tahun_akademik = TahunAkademik::where('status', 'aktif')->first();

        $jadwals = Jadwal::with('matkul', 'gedungs', 'tahun_akademik', 'dosen')->whereHas('matkul', function($query) use($tahun_akademik){
            $query->where('smt', $tahun_akademik->semester);
        })->latest()->get();


        foreach ($jadwals as $jadwal) {
            $jadwal->formatted_jam_mulai = Carbon::parse($jadwal->jam_mulai)->format('H:i');
            $jadwal->formatted_jam_selesai = Carbon::parse($jadwal->jam_selesai)->format('H:i');
        }
        $matkuls = Matkul::all();
        $kelas = Gedung::all();

        session(['nim' => $nim]);

        return view('dosen.bimbinganKrs.tambahkrs', compact('jadwals', 'matkuls', 'kelas', 'nim'));
    }

    public function storeKrs(Request $request)
    {
        $request->validate([
            'matkul_ids' => 'required|array',
        ]);

        $nim = session('nim');

        Log::info('nim : '.$nim);

        foreach ($request->matkul_ids as $matkulId) {
            $jadwal = Jadwal::findOrFail($matkulId);

            $kode_matkul = Matkul::whereHas('jadwal', function($query) use($matkulId) {
                $query->where('id', $matkulId);
            })->value('kode_matkul');

            $id_krs = Krs::whereHas('mahasiswa', function($query) use($nim) {
                    $query->where('nim', $nim);
                })->value('id');

            $id_ta = TahunAkademik::where('status', 'aktif')->value('id');

            if($id_krs === null) {
                $krs = Krs::create([
                    'nim' => $nim,
                    'id_ta' => $id_ta,
                ]);

                $id_krs = $krs->id;
            }

            // dd($id_krs);

            // Validasi Matkul Telah Ditambahkan
            $checkmatkul = DetailKrs::whereHas('jadwal.matkul', function($query) use($kode_matkul) {
                $query->where('kode_matkul', $kode_matkul);
            })->whereHas('krs', function($query) use($nim) {$query->where('nim', $nim);})->exists();


            if ($checkmatkul) {
                // dd($checkmatkul);
                continue;
            }
            
            $jadwal->update([
                'kuota' => $jadwal->kuota - 1
            ]);

            DetailKrs::create([
                'id_krs' => $id_krs,
                'id_jadwal' => $matkulId,
            ]);
            
        }

        $request->session()->forget('id_kelas');
        
        return redirect()->route('bimbingankrs.show', $nim)->with('success', 'KRS berhasil disimpan.'); 
    }

    public function acc($id_krs) 
    {   
        $krs = Krs::where('id', $id_krs)->first();

        $krs->update([
            'status' => 'acc'
        ]);

        return redirect()->route('bimbingankrs.index')->with('success', 'Berhasil Acc Krs'); 
    }

    public function batalAcc($id_krs) 
    {
        $krs = Krs::where('id', $id_krs)->first();

        $krs->update([
            'status' => 'belum-acc'
        ]);

        return redirect()->route('bimbingankrs.index')->with('success', 'Berhasil Acc Krs'); 
    }

}
