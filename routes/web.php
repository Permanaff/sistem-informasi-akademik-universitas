<?php

use App\Http\Controllers\Admin\FakultasController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MatkulController;
use App\Http\Controllers\Admin\ProdiController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/adm', function () {
    return view('admin.dashboard');
});

Route::resource('/adm/fakultas', FakultasController::class );
// Route::resource('/fakultas', FakultasController::class );
Route::resource('/adm/prodi', ProdiController::class );
Route::resource('/adm/matkul', MatkulController::class );
Route::resource('/adm/kelas', KelasController::class );
Route::resource('/adm/jadwal', JadwalController::class );


