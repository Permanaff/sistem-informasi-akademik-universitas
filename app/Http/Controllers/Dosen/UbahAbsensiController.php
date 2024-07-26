<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Jadwal;
use App\Models\Krs;
use App\Models\RiwayatAbsen;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UbahAbsensiController extends Controller
{
    private $nidn;

    public function __construct()
    {
        $this->nidn = Auth::user()->no_induk;
    }

    public function index() : View
    {
        $jadwal = Jadwal::with('matkul')->where('nidn', $this->nidn)->get();

        return view('dosen.ubahAbsensi', compact('jadwal'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_jadwal' => 'required',
            'pertemuan' => 'required',
        ]);

        // Validasi data 
        if ($validator->fails() or $request->id_jadwal == '0') {
            return response()->json($validator->errors(), 422);
        } 

        $absen = Krs::with(['mahasiswa' => function($query) {
            $query->orderBy('nim', 'asc');
        }, 'mahasiswa.riwayat_absen' => function($query) use ($request) {
            $query->where('pertemuan', $request->pertemuan);
        }])
        ->where('id_jadwal', $request->id_jadwal)
        ->get();

        $dataAbsen = $absen->map(function ($item) {
            $riwayatAbsen = $item->mahasiswa->riwayat_absen->first();
            return [
                'nama' => $item->mahasiswa->nama,
                'nim' => $item->mahasiswa->nim,
                'ket' => $riwayatAbsen ? $riwayatAbsen->ket : '-',
            ];
        });

        return response()->json([
            'success' => true, 
            'data' => [
                'mahasiswa' => $dataAbsen,
            ]
        ]);
    }

    public function updateAbsen(Request $request)
    {
        // Log::info($request);
        $validator = Validator::make($request->all(), [
            'data.*.nim' => 'required|exists:resources,nim', 
            'data.*.ket' => 'required|string',
            'absen.id_jadwal' => 'required|string',
            'absen.pertemuan' => 'required|string',
        ]);

        // Validasi data 
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // } 

        $datas = $request->input('data');
        $absens = $request->input('absen');

        $kode_absen = Str::random(10);

        $absen = Absen::create([
                    'id_jadwal' => $absens['id_jadwal'],
                    'pertemuan' => $absens['pertemuan'],
                    'ket' => '-',
                    'kode_absen' => $kode_absen,
                    'batas_mulai' => now(),
                    'batas_selesai' => now(),
                ]);

        $id_absen = $absen->id;

        foreach ($datas as $data) {
            try {
                // Mencari entri RiwayatAbsen yang ada
                $presensi = RiwayatAbsen::where('nim', $data['nim'])
                                        ->where('pertemuan', $absens['pertemuan'])
                                        ->firstOrFail();
    
                // Jika ditemukan, update data
                $presensi->update([
                    'id_absen'  => $id_absen, 
                    'nim'  => $data['nim'], 
                    'pertemuan'  => $absens['pertemuan'], 
                    'ket'  => $data['ket'], 
                ]);
                Log::info($data['ket']);

            } catch (ModelNotFoundException $e) {
                // Jika tidak ditemukan, buat entri baru
                Log::info($id_absen);
                RiwayatAbsen::create([
                    'id_absen'  => $id_absen, 
                    'nim'  => $data['nim'],
                    'pertemuan'  => $absens['pertemuan'], 
                    'ket'  => $data['ket'], 
                ]);
                Log::info($data['ket']);
            }
        }

        return response()->json([
            'success' => true, 
        ]);
    }
}

