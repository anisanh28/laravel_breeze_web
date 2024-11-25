<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Evaluasi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check()) {
            if (Auth::user()->role === 'guru') {
                return $next($request);
            }

            if (Auth::user()->role === 'siswa') {
                if (in_array($request->route()->getActionMethod(), ['index', 'show','submitEvaluasi'])) {
                    return $next($request);
                }
            }
        }
        return redirect()->route('login')->with('error', 'Anda tidak memiliki izin untuk mengakses materi ini.');
    }
}
