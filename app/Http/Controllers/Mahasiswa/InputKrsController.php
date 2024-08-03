<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\DetailKrs;
use App\Models\Fakultas;
use App\Models\Gedung;
use App\Models\Jadwal;
use App\Models\JadwalKrs;
use App\Models\KalenderAkademik;
use App\Models\Krs;
use App\Models\Matkul;
use App\Models\Prodi;
use App\Models\TahunAjar;
use App\Models\TahunAkademik;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class InputKrsController extends Controller
{
    private $nim;

    public function __construct()
    {
        $this->nim = Auth::user()->no_induk;
    }

    public function index() : View
    {
        $mahasiswaId = Auth::user()->no_induk;
        $krs = DetailKrs::with('krs','jadwal', 'jadwal.matkul', 'jadwal.tahun_akademik', 'jadwal.gedungs')->whereHas('krs', function($query) {
            $query->where('nim', $this->nim);
        })->get();

        $id_fakultas = Fakultas::whereHas('prodi', function ($query)  use($mahasiswaId)  {
            $query->whereHas('mahasiswa', function ($query) use($mahasiswaId) {
                $query->where('nim', $mahasiswaId);
            });
        })->value('id');

        // dd($krs->toArray());

        $currentDateTime = Carbon::now()->toDateTimeString();

        $periodeCheck = JadwalKrs::where('id_fakultas', $id_fakultas)
                            ->where('tgl_mulai', '<=', $currentDateTime)
                            ->where('tgl_selesai', '>=', $currentDateTime)
                            ->get();

        if ($periodeCheck->isEmpty()) {
            $periodeKrs = 'non-aktif';
        } else {
            $periodeKrs = 'aktif';
        }

        foreach ($krs as $kr) {
            $kr->formatted_jam_mulai = Carbon::parse($kr->jadwal->jam_mulai)->format('H:i');
            $kr->formatted_jam_selesai = Carbon::parse($kr->jadwal->jam_selesai)->format('H:i');
        }

        $ta = TahunAkademik::all()->where('status', 'aktif');
        $status_krs = Krs::where('nim', $this->nim)->whereHas('tahun_akademik', function($query) {
            $query->where('status', 'aktif');
        })->value('status');

        // dd($status_krs);

        return view('mahasiswa.inputkrs', compact('krs', 'ta', 'periodeKrs', 'status_krs'));
    }   
    
    public function daftarMatkul() : View
    {
        $jadwals = Jadwal::with('matkul', 'gedungs', 'tahun_akademik', 'dosen')->latest()->get();

        foreach ($jadwals as $jadwal) {
            $jadwal->formatted_jam_mulai = Carbon::parse($jadwal->jam_mulai)->format('H:i');
            $jadwal->formatted_jam_selesai = Carbon::parse($jadwal->jam_selesai)->format('H:i');
        }
        $matkuls = Matkul::all();
        $kelas = Gedung::all();
        
        return view('mahasiswa.daftarMatkul', compact('jadwals', 'matkuls', 'kelas'));
    }

    public function tambahKrs() : View
    {
        $jadwals = Jadwal::with('matkul', 'gedungs', 'tahun_akademik', 'dosen')->latest()->get();

        foreach ($jadwals as $jadwal) {
            $jadwal->formatted_jam_mulai = Carbon::parse($jadwal->jam_mulai)->format('H:i');
            $jadwal->formatted_jam_selesai = Carbon::parse($jadwal->jam_selesai)->format('H:i');
        }
        $matkuls = Matkul::all();
        $kelas = Gedung::all();

        // dd($jadwal->toArray());
        
        return view('mahasiswa.tambahkrs', compact('jadwals', 'matkuls', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matkul_ids' => 'required|array',
        ]);
        // $mahasiswaId = auth()->id(); // Asumsi mahasiswa sudah login
        $mahasiswaId = Auth::user()->no_induk;


        foreach ($request->matkul_ids as $matkulId) {
            $jadwal = Jadwal::findOrFail($matkulId);

            $kode_matkul = Matkul::whereHas('jadwal', function($query) use($matkulId) {
                $query->where('id', $matkulId);
            })->value('kode_matkul');

            $id_krs = Krs::whereHas('mahasiswa', function($query) {
                    $query->where('nim', $this->nim);
                })->value('id');

            $id_ta = TahunAkademik::where('status', 'aktif')->value('id');

            if($id_krs === null) {
                $krs = Krs::create([
                    'nim' => $this->nim,
                    'id_ta' => $id_ta,
                ]);

                $id_krs = $krs->id;
            }

            // dd($id_krs);

            // Validasi Matkul Telah Ditambahkan
            $checkmatkul = DetailKrs::whereHas('jadwal.matkul', function($query) use($kode_matkul) {
                $query->where('kode_matkul', $kode_matkul);
            })->whereHas('krs', function($query) {$query->where('nim', $this->nim);})->exists();

            Log::info($checkmatkul);

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

        return redirect('/std/krs')->with('success', 'KRS berhasil disimpan.'); 
    }

    public function deleteKrs($id_krs) 
    {
        $krs = Krs::findOrFail($id_krs);

        $jadwal = Jadwal::findOrFail($krs->id_jadwal);

        $jadwal->update([
            'kuota' => $jadwal->kuota + 1
        ]);

        $krs->delete();

        return redirect('/std/krs')->with('success', 'KRS berhasil Dihapus.'); 
    }
}
