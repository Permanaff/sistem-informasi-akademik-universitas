<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {   
        if(auth()->user()->role == $role){
            return $next($request);
        }

        if (auth()->user()->role == 'mahasiswa') {
            return redirect('std');
        } else if (auth()->user()->role == 'dosen') {
            return redirect('dsn');
        } else if (auth()->user()->role == 'admin') {
            return redirect('adm');
        }
    }
}
