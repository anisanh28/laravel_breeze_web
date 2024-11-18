<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class JawabanWarmUp
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
            $user = Auth::user();
            
            // Untuk siswa: hanya izinkan akses pada metode tertentu
            if ($user->role === 'siswa') {
                if (in_array($request->route()->getActionMethod(), ['create', 'store', 'edit', 'update', 'show', 'destroy'])) {
                    return $next($request); // Lanjutkan jika siswa mengakses metode yang diperbolehkan
                }
            }

            // Untuk guru: hanya izinkan akses pada metode tertentu
            if ($user->role === 'guru') {
                if (in_array($request->route()->getActionMethod(), ['index'])) {
                    return $next($request); // Lanjutkan jika guru mengakses metode yang diperbolehkan
                }
            }
        }

        // Jika user tidak diizinkan, redirect ke login dengan pesan error
        return redirect()->route('login')->with('error', 'Anda tidak memiliki izin untuk mengakses materi ini.');
    }
}
