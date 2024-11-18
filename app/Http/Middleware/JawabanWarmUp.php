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
            if (Auth::user()->role === 'siswa') {
                if (in_array($request->route()->getActionMethod(), ['create', 'store','edit','delete','show'])) {
                    return $next($request);
                }
            }

            if (Auth::user()->role === 'guru') {
                if (in_array($request->route()->getActionMethod(), ['index'])) {
                    return $next($request);
                }
            }
        }

    return redirect()->route('login')->with('error', 'Anda tidak memiliki izin untuk mengakses materi ini.');
}
}
