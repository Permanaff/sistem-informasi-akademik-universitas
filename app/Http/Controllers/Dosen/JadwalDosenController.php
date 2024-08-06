<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\TahunAkademik;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JadwalDosenController extends Controller
{
    private $nidn;

    public function __construct()
    {
        $this->nidn = Auth::user()->no_induk;
    }

    public function index() : View
    {
        $jadwals = Jadwal::with('matkul', 'gedungs')->where('nidn', $this->nidn)->whereHas('tahun_akademik', function($query) {
            $query->where('status', 'aktif');
        })->get();

        foreach ($jadwals as $jadwal) {
            $jadwal->formatted_jam_mulai = Carbon::parse($jadwal->jam_mulai)->format('H:i');
            $jadwal->formatted_jam_selesai = Carbon::parse($jadwal->jam_selesai)->format('H:i');
        }

        Log::info($jadwals);
        return view('dosen.jadwalDosen', compact('jadwals'));
    }
}
