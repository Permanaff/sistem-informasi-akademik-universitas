<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Jadwal;
use App\Models\Krs;
use App\Models\Presensi;
use App\Models\RiwayatAbsen;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
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

    public function dataMahasiswa(Request $request) : View
    {
        $request->validate([
            'id_jadwal' => 'required',
            'pertemuan' => 'required'
        ]);

        $old_data = (object)  [
            'id_jadwal' => $request->id_jadwal,
            'pertemuan' => $request->pertemuan,
        ];

        

        $jadwal = Jadwal::with('matkul')->where('nidn', $this->nidn)->get();

        $absen = Krs::with(['mahasiswa' => function($query) {
            $query->orderBy('nim', 'asc');
        }, 'mahasiswa.presensi' => function($query) use ($request) {
            $query->where('pertemuan', $request->pertemuan);
        }])
        ->where('id_jadwal', $request->id_jadwal)
        ->get();

        $dataAbsen = $absen->map(function ($item) {
            $riwayatAbsen = $item->mahasiswa->presensi->first();
            return (object) [
                'nama' => $item->mahasiswa->nama,
                'nim' => $item->mahasiswa->nim,
                'ket' => $riwayatAbsen ? $riwayatAbsen->ket : '-',
            ];
        });

        // dd($request->pertemuan);
        // dd($absen->toArray());
        // dd($old_data);

        

        return view('dosen.ubahAbsensi', compact('jadwal', 'dataAbsen', 'old_data'));
    }

    public function update (Request $request) 
    {
        
        $request->validate([
            'presenis.*.nim' => 'required|exists:students,id',
            'presenis.*.ket' => 'required|in:present,absent,late',
            'jadwal_id'      => 'required',
            'pert'      => 'required',
        ]);





        foreach ($request->presensi as $data) {
            try {

                // Mencari entri Presensi yang ada
                $checkPresensi = Presensi::where('nim', $data['nim'])->where('pertemuan', $request->pert)->firstOrFail();
                
                // Jika ditemukan, update data
                $checkPresensi->update([
                    'id_jadwal'  => $request->jadwal_id, 
                    'nim'  => $data['nim'], 
                    'pertemuan'  => $request->pert, 
                    'ket'  => $data['ket'] != '-' ? $data['ket'] : null, 
                ]);
                

            } catch (ModelNotFoundException $e) {

                // Jika tidak ditemukan, buat entri baru
                Presensi::create([
                    'id_jadwal'  => $request->jadwal_id, 
                    'nim'  => $data['nim'], 
                    'pertemuan'  => $request->pert, 
                    'ket'  => $data['ket'] != '-' ? $data['ket'] : null, 
                ]);
                // Log::info($data['ket']);
            }
        }


        // dd($request->toArray());

        return redirect()->route('ubahabsen.index')->with('success', 'Data Presensi Berhasil Diubah!');
    }
}


