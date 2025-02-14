<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSekolah
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $siswa = $user->dataSiswa;
        
        if (!$siswa || $siswa->sekolah_id != $request->sekolah_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
