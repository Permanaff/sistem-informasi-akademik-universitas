<?php

use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\FakultasController;
use App\Http\Controllers\Admin\GedungController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\JadwalKrsController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MatkulController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dosen\BimbinganKrsController;
use App\Http\Controllers\Dosen\DaftarMahasiswaController;
use App\Http\Controllers\Dosen\HomeDosenController;
use App\Http\Controllers\Dosen\JadwalDosenController;
use App\Http\Controllers\Dosen\KelasBimbinganController;
use App\Http\Controllers\Dosen\NilaiMahasiswaController;
use App\Http\Controllers\Dosen\PresensiController;
use App\Http\Controllers\Dosen\RiwayatAbsenController;
use App\Http\Controllers\Dosen\UbahAbsensiController;
use App\Http\Controllers\Mahasiswa\CetakKrsController;
use App\Http\Controllers\Mahasiswa\HomeMahasiswaController;
use App\Http\Controllers\Mahasiswa\InputKrsController;
use App\Http\Controllers\Mahasiswa\KhsController;
use App\Http\Controllers\Mahasiswa\PresensiMahasiswaController;
use App\Http\Controllers\Mahasiswa\ScanPresensiController;
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
    
    // --------------- Route Admin ---------------
    // Route::get('/adm', [FakultasController::class, 'index'] )->middleware('userAccess:admin');
    // Route::resource('/adm/fakultas', FakultasController::class )->middleware('userAccess:admin');
    // Route::resource('/adm/prodi', ProdiController::class )->middleware('userAccess:admin');
    // Route::resource('/adm/matkul', MatkulController::class )->middleware('userAccess:admin');
    // Route::resource('/adm/kelas', GedungController::class )->middleware('userAccess:admin');
    // Route::resource('/adm/jadwal', JadwalController::class )->middleware('userAccess:admin');
    // Route::resource('/adm/dosen', DosenController::class )->middleware('userAccess:admin');
    // Route::resource('/adm/student', MahasiswaController::class )->middleware('userAccess:admin');
    // Route::resource('/adm/jadwalkrs', JadwalKrsController::class )->middleware('userAccess:admin');

    Route::get('/adm', [FakultasController::class, 'index'] )->middleware('userAccess:admin');
    Route::prefix('/adm')->group(function() {
        Route::resource('/fakultas', FakultasController::class )->middleware('userAccess:admin');
        Route::resource('/prodi', ProdiController::class )->middleware('userAccess:admin');
        Route::resource('/matkul', MatkulController::class )->middleware('userAccess:admin');
        Route::resource('/kelas', GedungController::class )->middleware('userAccess:admin');
        Route::resource('/jadwal', JadwalController::class )->middleware('userAccess:admin');
        Route::resource('/dosen', DosenController::class )->middleware('userAccess:admin');
        Route::resource('/student', MahasiswaController::class )->middleware('userAccess:admin');
        Route::resource('/jadwalkrs', JadwalKrsController::class )->middleware('userAccess:admin');
    });
    
    // --------------- Route Dosen ---------------
    Route::get('/dsn', [HomeDosenController::class, 'index'] )->middleware('userAccess:dosen');
    Route::resource('/dsn/presensi', PresensiController::class )->middleware('userAccess:dosen');
    Route::resource('/dsn/bimbingan', KelasBimbinganController::class )->middleware('userAccess:dosen');
    Route::resource('/dsn/daftarmahasiswa', DaftarMahasiswaController::class )->middleware('userAccess:dosen');
    Route::resource('/dsn/jadwalmengajar', JadwalDosenController::class )->middleware('userAccess:dosen');
    
    // Route Riwayat Absen
    Route::get('/dsn/absenmahasiswa', [RiwayatAbsenController::class, 'index'] )->middleware('userAccess:dosen');
    Route::post('/dsn/absenmahasiswa', [RiwayatAbsenController::class, 'daftarMahasiswa'] )->name('daftarMahasiswa')->middleware('userAccess:dosen');

    // Route Ubah Absen Dosen
    Route::get('/dsn/ubahabsen',[UbahAbsensiController::class, 'index'] )->name('ubahabsen.index')->middleware('userAccess:dosen');
    // Route::post('/dsn/ubahabsen', [UbahAbsensiController::class, 'store'] )->middleware('userAccess:dosen');
    // Route::put('/dsn/ubahabsen/update', [UbahAbsensiController::class, 'updateAbsen'] )->middleware('userAccess:dosen');
    Route::post('/dsn/ubahabsen', [UbahAbsensiController::class, 'dataMahasiswa'] )->name('getDataMahasiswa')->middleware('userAccess:dosen');
    Route::post('/dsn/ubahabsen/update', [UbahAbsensiController::class, 'update'] )->name('ubahabsen.update')->middleware('userAccess:dosen');

    
    // Route Nilai Mahasiswa
    Route::get('/dsn/nilaimahasiswa', [NilaiMahasiswaController::class, 'index'])->name('nilaimahasiswa.index')->middleware('userAccess:dosen');
    Route::post('/dsn/nilaimahasiswa', [NilaiMahasiswaController::class, 'show'])->name('nilaimahasiswa.show')->middleware('userAccess:dosen');
    Route::post('/dsn/nilaimahasiswa/inputnilai', [NilaiMahasiswaController::class, 'inputPage'])->name('nilai.input')->middleware('userAccess:dosen');
    Route::post('/dsn/nilaimahasiswa/input', [NilaiMahasiswaController::class, 'inputNilai'])->name('nilai.inputnilai')->middleware('userAccess:dosen');

    // Route bimbingan KRS
    Route::get('/dsn/bimbingankrs', [BimbinganKrsController::class, 'index'])->name('bimbingankrs.index')->middleware('userAccess:dosen');
    Route::get('/dsn/bimbingankrs/{nim}', [BimbinganKrsController::class, 'show'])->name('bimbingankrs.show')->middleware('userAccess:dosen');
    Route::get('/dsn/bimbingankrs/daftarmatkul', [BimbinganKrsController::class, 'daftarMatkul'])->name('bimbingankrs.daftarmatkul')->middleware('userAccess:dosen');
    Route::get('/dsn/bimbingankrs/delete/{id_krs}', [BimbinganKrsController::class, 'deletekrs'])->name('bimbingankrs.delete')->middleware('userAccess:dosen');
    Route::get('/dsn/bimbingankrs/tambahkrs/{nim}', [BimbinganKrsController::class, 'tambahkrs'])->name('bimbingankrs.tambahkrs')->middleware('userAccess:dosen');
    Route::post('/dsn/bimbingankrs/storekrs', [BimbinganKrsController::class, 'storeKrs'])->name('bimbingankrs.store')->middleware('userAccess:dosen');
    Route::get('/dsn/bimbingankrs/acc/{id_krs}', [BimbinganKrsController::class, 'acc'])->name('bimbingankrs.acc')->middleware('userAccess:dosen');
    Route::get('/dsn/bimbingankrs/batalacc/{id_krs}', [BimbinganKrsController::class, 'batalAcc'])->name('bimbingankrs.batalacc')->middleware('userAccess:dosen');


    
    // --------------- Route Mahasiswa ---------------
    Route::get('/std', [HomeMahasiswaController::class, 'index'])->middleware('userAccess:mahasiswa');
    
    // Mahasiswa KRS
    Route::get('/std/krs', [InputKrsController::class, 'index'])->middleware('userAccess:mahasiswa');
    Route::get('/std/krs/daftarmatkul', [InputKrsController::class, 'daftarMatkul'])->middleware('userAccess:mahasiswa');
    Route::get('/std/krs/tambahkrs', [InputKrsController::class, 'tambahKrs'])->middleware('userAccess:mahasiswa');
    Route::get('/std/krs/deleteKrs/{id_krs}', [InputKrsController::class, 'deleteKrs'])->name('krs.delete')->middleware('userAccess:mahasiswa');

    Route::post('/std/scanpresensi', [InputKrsController::class, 'store'])->name('std.krs.store')->middleware('userAccess:mahasiswa');
    
    // Route::get('/std/krs/daftarMatkul', [InputKrsController::class, 'daftarMatkul'])->name('std.krs.daftarMatkul');

    Route::resource('/std/kehadiran', PresensiMahasiswaController::class )->middleware('userAccess:mahasiswa');
    Route::resource('/std/scanabsen', ScanPresensiController::class )->middleware('userAccess:mahasiswa');
    Route::resource('/std/khs', KhsController::class )->middleware('userAccess:mahasiswa');

    Route::resource('/std/cetakkrs', CetakKrsController::class )->middleware('userAccess:mahasiswa');
});
