<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gedung;
use App\Models\Jadwal;
use App\Models\Matkul;
use App\Models\TahunAjar;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function index() : View 
    {
        $jadwals = Jadwal::with('matkul', 'gedungs', 'tahun_ajar')->latest()->get();

        foreach ($jadwals as $jadwal) {
            $jadwal->formatted_jam_mulai = Carbon::parse($jadwal->jam_mulai)->format('H:i');
            $jadwal->formatted_jam_selesai = Carbon::parse($jadwal->jam_selesai)->format('H:i');
        }
        $matkuls = Matkul::all();
        $kelas = Gedung::all();

        return view('admin.jadwal', compact('jadwals' ,'matkuls', 'kelas'));
    }

    public function store(Request $request): RedirectResponse
    {   
        $request->validate([
            'matkul' => 'required',
            'ruang' => 'required',
            'kelas' => 'required',
            'hari' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
            'kuota' => 'required|integer',
        ]);

        $id_ta = TahunAjar::where('status', 'aktif')->value('id');

        Jadwal::create([
            'id_matkul' => $request->matkul,
            'id_kelas' => $request->ruang,
            'id_ta' => $id_ta,
            'kls' => $request->kelas,
            'hari' => $request->hari,
            'jam_mulai' => $request->mulai,
            'jam_selesai' => $request->selesai,
            'kuota' => $request->kuota,
        ]);

        return redirect()->route('jadwal.index')->with(['success' => 'Berhasil Menambahkan Jadwal']);
    }
}
