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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class InputKrsController extends Controller
{
    public function index() : View
    {
        $mahasiswaId = Auth::user()->no_induk;
        $krs = Krs::with('mahasiswa', 'jadwal', 'jadwal.matkul', 'jadwal.tahun_ajar', 'jadwal.gedungs')->where('nim', $mahasiswaId)->get();

        foreach ($krs as $kr) {
            $kr->formatted_jam_mulai = Carbon::parse($kr->jadwal->jam_mulai)->format('H:i');
            $kr->formatted_jam_selesai = Carbon::parse($kr->jadwal->jam_selesai)->format('H:i');
        }

        $ta = TahunAjar::all()->where('status', 'aktif');
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
