<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalKrs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalKrsController extends Controller
{
    public function index() : View
    {
        $data = JadwalKrs::with('tahun_akademik', 'fakultas')->get();

        $jadwal_krs = $data->map(function ($item) {
            return (object) [
                'fakultas' => $item->fakultas->nama_fakultas,
                'semester' => $item->tahun_akademik->semester,
                'ta' => $item->tahun_akademik->tahun_ajaran,
                'jadwal' => Carbon::parse($item->tgl_mulai)->format('d-m-Y H:i').' - '.Carbon::parse($item->tgl_selesai)->format('d-m-Y H:i'),
                'status' => ($item->tgl_mulai <= now() && now() <= $item->tgl_selesai) ? 'aktif' : 'non-aktif',
                'jadwal_selesai' => $item->tgl_selesai,
            ];
        })->sortBy('jadwal_selesai');

        // dd($jadwal_krs->toArray());
        return view('admin.jadwalkrs', compact('jadwal_krs'));
    }
}
