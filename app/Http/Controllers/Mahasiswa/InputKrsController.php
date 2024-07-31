<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\Gedung;
use App\Models\Jadwal;
use App\Models\JadwalKrs;
use App\Models\KalenderAkademik;
use App\Models\Krs;
use App\Models\Matkul;
use App\Models\Prodi;
use App\Models\TahunAjar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class InputKrsController extends Controller
{
    public function index() : View
    {
        $mahasiswaId = Auth::user()->no_induk;
        $krs = Krs::with('mahasiswa', 'jadwal', 'jadwal.matkul', 'jadwal.tahun_akademik', 'jadwal.gedungs')->where('nim', $mahasiswaId)->get();

        $id_fakultas = Fakultas::whereHas('prodi', function ($query)  use($mahasiswaId)  {
            $query->whereHas('mahasiswa', function ($query) use($mahasiswaId) {
                $query->where('nim', $mahasiswaId);
            });
        })->value('id');

        // dd($id_fakultas);

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

        // dd($currentDateTime);
        // dd($periodeKrs);
        // dd($periodeCheck->toArray());

        foreach ($krs as $kr) {
            $kr->formatted_jam_mulai = Carbon::parse($kr->jadwal->jam_mulai)->format('H:i');
            $kr->formatted_jam_selesai = Carbon::parse($kr->jadwal->jam_selesai)->format('H:i');
        }

        $ta = KalenderAkademik::all()->where('status', 'aktif');
        // dd($ta->toArray());
        return view('mahasiswa.inputkrs', compact('krs', 'ta', 'periodeKrs'));
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
            
            $jadwal->update([
                'kuota' => $jadwal->kuota - 1
            ]);

            Krs::create([
                'nim' => $mahasiswaId,
                'id_jadwal' => $matkulId,
            ]);
        }

        return redirect('/std/krs')->with('success', 'KRS berhasil disimpan.');

        
    }
}
