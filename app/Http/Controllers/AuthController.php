<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ], [
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'password.required' => 'Password wajib diisi.'
    ]);
    
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        switch(Auth::user()->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'guru':
                return redirect()->route('guru.dashboard');
            case 'siswa':
                return redirect()->route('siswa.dashboard');
            case 'sekolah':
                return redirect()->route('school.dashboard');
        }
    }

    return back()->withErrors([
        'email' => __('auth.failed'),
    ]);
    
}

public function showForgotPasswordForm()
{
    return view('auth.forgot-password');
}

public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email|exists:users,email']);

    $token = Str::random(64);

    DB::table('password_resets')->insert([
        'email' => $request->email,
        'token' => $token,
        'created_at' => now()
    ]);

    Mail::send('auth.email-reset', ['token' => $token], function($message) use ($request) {
        $message->to($request->email);
        $message->subject('Reset Password Notification');
    });

    return back()->with('message', 'Kami telah mengirimkan link reset password ke email Anda!');
}

public function showResetPasswordForm($token)
{
    return view('auth.reset-password', ['token' => $token]);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|string|min:8|confirmed',
        'token' => 'required'
    ]);

    $record = DB::table('password_resets')->where([
        'email' => $request->email,
        'token' => $request->token
    ])->first();

    if (!$record) {
        return back()->withErrors(['email' => 'Invalid token!']);
    }

    $user = User::where('email', $request->email)->first();
    $user->password = Hash::make($request->password);
    $user->save();

    DB::table('password_resets')->where(['email' => $request->email])->delete();

    return redirect('/login')->with('message', 'Your password has been successfully changed!');
}

public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
}
protected function authenticated(Request $request, $user)
    {
        // Check if user is school and is_active status
        if ($user->role === 'sekolah') {
            $school = $user->sekolah;
            
            // If school is not active, log them out with a message
            if (!$school || !$school->is_active) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Akun sekolah Anda belum diaktifkan oleh admin. Silahkan hubungi admin untuk aktivasi.');
            }
        }

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'sekolah') {
            return redirect()->route('sekolah.dashboard');
        }

        return redirect('/');
    }
}