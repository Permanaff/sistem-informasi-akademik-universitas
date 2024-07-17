<?php

use App\Http\Controllers\FakultasController;
use App\Http\Controllers\ProdiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/adm', function () {
    return view('admin.dashboard');
});

Route::resource('/adm/fakultas', FakultasController::class );
Route::resource('/fakultas', FakultasController::class );
Route::resource('/adm/prodi', ProdiController::class );


