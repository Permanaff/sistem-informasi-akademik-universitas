<?php

use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\FakultasController;
use App\Http\Controllers\Admin\GedungController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MatkulController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dosen\DaftarMahasiswaController;
use App\Http\Controllers\Dosen\HomeDosenController;
use App\Http\Controllers\Dosen\KelasBimbinganController;
use App\Http\Controllers\Dosen\PresensiController;
use App\Http\Controllers\Mahasiswa\HomeMahasiswaController;
use App\Http\Controllers\Mahasiswa\InputKrsController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('auth.login');
// });

route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/', [AuthController::class, 'login']);
});


// Route::get('/adm', function () {
//     return view('admin.dashboard');
// });

Route::middleware(['auth'])->group(function() {
    Route::get('/logout', [AuthController::class, 'logout']);
    
    // Route Admin
    Route::get('/adm', [FakultasController::class, 'index'] )->middleware('userAccess:admin');
    Route::resource('/adm/fakultas', FakultasController::class )->middleware('userAccess:admin');
    Route::resource('/adm/prodi', ProdiController::class )->middleware('userAccess:admin');
    Route::resource('/adm/matkul', MatkulController::class )->middleware('userAccess:admin');
    Route::resource('/adm/kelas', GedungController::class )->middleware('userAccess:admin');
    Route::resource('/adm/jadwal', JadwalController::class )->middleware('userAccess:admin');
    Route::resource('/adm/dosen', DosenController::class )->middleware('userAccess:admin');
    Route::resource('/adm/student', MahasiswaController::class )->middleware('userAccess:admin');
    
    // Route Dosen
    Route::get('/dsn', [HomeDosenController::class, 'index'] )->middleware('userAccess:dosen');
    Route::resource('/dsn/presensi', PresensiController::class )->middleware('userAccess:dosen');
    Route::resource('/dsn/bimbingan', KelasBimbinganController::class )->middleware('userAccess:dosen');
    Route::resource('/dsn/daftarmahasiswa', DaftarMahasiswaController::class )->middleware('userAccess:dosen');
    
    // Route Mahasiswa
    Route::get('/std', [HomeMahasiswaController::class, 'index'])->middleware('userAccess:mahasiswa');
    
    // Mahasiswa KRS
    Route::get('/std/krs', [InputKrsController::class, 'index'])->middleware('userAccess:mahasiswa');
    Route::get('/std/krs/daftarmatkul', [InputKrsController::class, 'daftarMatkul'])->middleware('userAccess:mahasiswa');
    Route::get('/std/krs/tambahkrs', [InputKrsController::class, 'tambahKrs'])->middleware('userAccess:mahasiswa');
    Route::post('/std/krs', [InputKrsController::class, 'store'])->name('std.krs.store')->middleware('userAccess:mahasiswa');
    
    // Route::get('/std/krs/daftarMatkul', [InputKrsController::class, 'daftarMatkul'])->name('std.krs.daftarMatkul');
});
