<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSchoolIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'sekolah') {
            // Check if the associated school record is active
            $school = Auth::user()->sekolah;
            
            if (!$school || !$school->is_active) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Akun sekolah Anda belum diaktifkan oleh admin.');
            }
        }

        return $next($request);
    }
}