<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Gedung;
use App\Models\Jadwal;
use App\Models\KalenderAkademik;
use App\Models\Krs;
use App\Models\Matkul;
use App\Models\TahunAjar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class InputKrsController extends Controller
{
    public function index() : View
    {
        $krs = Krs::with('mahasiswa', 'jadwal', 'jadwal.matkul', 'jadwal.tahun_ajar', 'jadwal.gedungs')->where('id_mahasiswa', 1)->get();

        foreach ($krs as $kr) {
            $kr->formatted_jam_mulai = Carbon::parse($kr->jadwal->jam_mulai)->format('H:i');
            $kr->formatted_jam_selesai = Carbon::parse($kr->jadwal->jam_selesai)->format('H:i');
        }

        $ta = TahunAjar::all()->where('status', 'aktif');
        Log::info($krs);
        return view('mahasiswa.inputkrs', compact('krs', 'ta'));
    }   
    
    public function daftarMatkul() : View
    {
        $jadwals = Jadwal::with('matkul', 'gedungs', 'tahun_ajar', 'dosen')->latest()->get();

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
        $jadwals = Jadwal::with('matkul', 'gedungs', 'tahun_ajar', 'dosen')->latest()->get();

        foreach ($jadwals as $jadwal) {
            $jadwal->formatted_jam_mulai = Carbon::parse($jadwal->jam_mulai)->format('H:i');
            $jadwal->formatted_jam_selesai = Carbon::parse($jadwal->jam_selesai)->format('H:i');
        }
        $matkuls = Matkul::all();
        $kelas = Gedung::all();
        
        return view('mahasiswa.tambahkrs', compact('jadwals', 'matkuls', 'kelas'));
    }

    public function store(Request $request)
    {
        Log::info($request);
        $request->validate([
            'matkul_ids' => 'required|array',
        ]);
        Log::info('a');
        // $mahasiswaId = auth()->id(); // Asumsi mahasiswa sudah login
        $mahasiswaId = '1';
        Log::info('b');

        foreach ($request->matkul_ids as $matkulId) {
            Log::info($mahasiswaId);
            Log::info($matkulId);
            Krs::create([
                'id_mahasiswa' => $mahasiswaId,
                'id_jadwal' => $matkulId,
            ]);
        }
        Log::info('c');

        return redirect('/std/krs')->with('success', 'KRS berhasil disimpan.');

        
    }
}
