<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Submateri
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
{
    if (Auth::check()) {
        if (Auth::user()->role === 'guru') {
            return $next($request); // Akses penuh untuk guru
        }

        if (Auth::user()->role === 'siswa') {
            // Hanya izinkan siswa untuk akses metode index dan show
            if (in_array($request->route()->getActionMethod(), ['index', 'show'])) {
                return $next($request);
            }
        }
    }

    // Pengguna tidak terautentikasi atau role tidak diizinkan
    return redirect()->route('login')->with('error', 'Anda tidak memiliki izin untuk mengakses materi ini.');
}
}
