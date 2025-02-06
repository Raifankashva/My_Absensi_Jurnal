<?php

namespace App\Http\Middleware;

use App\Models\AttendanceSetting;
use Closure;
use Illuminate\Http\Request;

class VerifySchoolToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->token ?? $request->route('token');
        
        if (!$token) {
            return redirect()->route('attendance.public.view')
                ->with('error', 'School token is required');
        }

        $setting = AttendanceSetting::where('token', $token)->first();
        
        if (!$setting) {
            return redirect()->route('attendance.public.view')
                ->with('error', 'Invalid school token');
        }

        // Add school setting to request for later use
        $request->merge(['school_setting' => $setting]);
        
        return $next($request);
    }
}