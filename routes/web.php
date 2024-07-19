<?php

use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\FakultasController;
use App\Http\Controllers\Admin\GedungController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\MatkulController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Dosen\HomeDosenController;
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

// Route Dosen
Route::resource('/dsn', HomeDosenController::class );



