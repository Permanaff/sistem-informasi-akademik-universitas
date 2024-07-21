<?php

use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\FakultasController;
use App\Http\Controllers\Admin\GedungController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MatkulController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Dosen\HomeDosenController;
use App\Http\Controllers\Dosen\PresensiController;
use App\Http\Controllers\Mahasiswa\HomeMahasiswaController;
use App\Http\Controllers\Mahasiswa\InputKrsController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/adm', function () {
    return view('admin.dashboard');
});

// Route Admin
Route::resource('/adm/fakultas', FakultasController::class );
Route::resource('/adm/prodi', ProdiController::class );
Route::resource('/adm/matkul', MatkulController::class );
Route::resource('/adm/kelas', GedungController::class );
Route::resource('/adm/jadwal', JadwalController::class );
Route::resource('/adm/dosen', DosenController::class );
Route::resource('/adm/student', MahasiswaController::class );

// Route Dosen
Route::get('/dsn', [HomeDosenController::class, 'index'] );
Route::resource('/dsn/presensi', PresensiController::class );



// Route Mahasiswa
Route::get('/std', [HomeMahasiswaController::class, 'index']);

// Mahasiswa KRS
Route::get('/std/krs', [InputKrsController::class, 'index']);
Route::get('/std/krs/daftarmatkul', [InputKrsController::class, 'daftarMatkul']);
Route::get('/std/krs/tambahkrs', [InputKrsController::class, 'tambahKrs']);
Route::post('/std/krs', [InputKrsController::class, 'store'])->name('std.krs.store');

// Route::get('/std/krs/daftarMatkul', [InputKrsController::class, 'daftarMatkul'])->name('std.krs.daftarMatkul');
