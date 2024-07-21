<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function index ()
    {
        return view('Auth/login');
    }

    function login(Request $request) 
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi'
        ]);

        $infologin = [
            'no_induk' => $request->email,
            'password' => $request->password
        ];


        if (Auth::attempt($infologin)) {
            // $user = User::where('email', $request->email)->first();
            // session(['email' => $user->email, 'name' => $user->name]);
            if (Auth::user()->role == 'mahasiswa') {
                return redirect('std');

            } else if (Auth::user()->role == 'dosen') {
                return redirect('dsn');

            } else if (Auth::user()->role == 'admin') {
                return redirect('adm');
            }
            
        } else {
            return redirect('/')->with('message', 'Username dan password yang dimasukkan tidak sesuai');
        }
    }

    function logout() 
    {
        Auth::logout();
        return redirect('/');
    }
}
