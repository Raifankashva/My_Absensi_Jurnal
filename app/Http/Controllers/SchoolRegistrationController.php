<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\OtpVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerificationMail;
use Illuminate\Support\Str;
use App\Models\Province;
use Carbon\Carbon;

class SchoolRegistrationController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        $provinces = Province::all();

        return view(('auth.school-register'), compact('provinces'));
    }

    /**
     * Handle school registration
     */
    public function register(Request $request)
    {
        // Validate form input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'npsn' => 'required|string|size:8|unique:sekolahs',
            'nama_sekolah' => 'required|string|max:255',
            'jenjang' => 'required|in:SD,SMP,SMA,SMK',
            'status' => 'required|in:Negeri,Swasta',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'kode_pos' => 'required|string|size:5',
            'no_telp' => 'required|string|max:15',
            'kepala_sekolah' => 'required|string|max:255',
            'nip_kepala_sekolah' => 'nullable|string|size:18',
            'website' => 'nullable|url',
            'akreditasi' => 'nullable|string|size:1',
            'foto' => 'nullable|image|max:2048',
            'is_active' => false, // Account starts as inactive until verified
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Begin transaction
        \DB::beginTransaction();

        try {
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'role' => 'sekolah',
            ]);

            // Process photo if uploaded
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('sekolah_photos', 'public');
            }

            // Create sekolah
            $sekolah = Sekolah::create([
                'user_id' => $user->id,
                'npsn' => $request->npsn,
                'nama_sekolah' => $request->nama_sekolah,
                'jenjang' => $request->jenjang,
                'status' => $request->status,
                'alamat' => $request->alamat,
                'province_id' => $request->province_id,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
                'village_id' => $request->village_id,
                'kode_pos' => $request->kode_pos,
                'no_telp' => $request->no_telp,
                'email' => $request->email,
                'website' => $request->website,
                'akreditasi' => $request->akreditasi,
                'kepala_sekolah' => $request->kepala_sekolah,
                'nip_kepala_sekolah' => $request->nip_kepala_sekolah,
                'foto' => $fotoPath,
            ]);

            // Generate OTP
            $otp = mt_rand(100000, 999999);
            $expiredAt = Carbon::now()->addMinutes(10); // OTP expires after 10 minutes

            // Save OTP to database
            OtpVerification::create([
                'user_id' => $user->id,
                'otp' => $otp,
                'expired_at' => $expiredAt,
                'verified_at' => null
            ]);

            // Send OTP email
            Mail::to($user->email)->send(new OtpVerificationMail($user, $otp));

            \DB::commit();

            return redirect()->route('verification.notice')
                ->with('success', 'Pendaftaran berhasil! Silakan cek email Anda untuk kode OTP verifikasi.');

        } catch (\Exception $e) {
            \DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Show OTP verification form
     */
    public function showOtpForm()
    {
        return view('auth.verify-otp');
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric|digits:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return redirect()->back()
                ->with('error', 'Email tidak ditemukan.')
                ->withInput();
        }

        $otpVerification = OtpVerification::where('user_id', $user->id)
            ->where('otp', $request->otp)
            ->where('expired_at', '>', Carbon::now())
            ->whereNull('verified_at')
            ->first();

        if (!$otpVerification) {
            return redirect()->back()
                ->with('error', 'Kode OTP tidak valid atau sudah kadaluarsa.')
                ->withInput();
        }

        // Mark OTP as verified
        $otpVerification->update([
            'verified_at' => Carbon::now()
        ]);

        // Activate user account
        $user->update([
            'is_active' => true,
            'email_verified_at' => Carbon::now()
        ]);

        return redirect()->route('login')
            ->with('success', 'Verifikasi berhasil! Akun Anda telah aktif. Silakan login.');
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return redirect()->back()
                ->with('error', 'Email tidak ditemukan.')
                ->withInput();
        }

        // Delete previous OTPs
        OtpVerification::where('user_id', $user->id)
            ->whereNull('verified_at')
            ->delete();

        // Generate new OTP
        $otp = mt_rand(100000, 999999);
        $expiredAt = Carbon::now()->addMinutes(10);

        // Save OTP to database
        OtpVerification::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expired_at' => $expiredAt,
            'verified_at' => null
        ]);

        // Send OTP email
        Mail::to($user->email)->send(new OtpVerificationMail($user, $otp));

        return redirect()->back()
            ->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}