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
        'email' => 'The provided credentials do not match our records.',
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

    return back()->with('message', 'We have emailed your password reset link!');
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
}