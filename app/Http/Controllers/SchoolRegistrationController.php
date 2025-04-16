<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sekolah;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SchoolRegistrationOTP;
use App\Models\OtpCode;

class SchoolRegistrationController extends Controller
{
    /**
     * Display the registration form
     */
    public function showRegistrationForm()
    {
        // Load provinces for dropdown
        $provinces = \App\Models\Province::all();
        return view('auth.school-register', compact('provinces'));
    }

    /**
     * Handle school registration
     */
    
     public function register(Request $request)
     {
         // Validate the request
         $validator = Validator::make($request->all(), [
             'name' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:users',
             'password' => 'required|string|min:8|confirmed',
             'no_hp' => 'required|string|max:15',
             'alamat' => 'required|string|max:255',
             'npsn' => 'required|string|size:8|unique:sekolahs',
             'nama_sekolah' => 'required|string|max:255',
             'jenjang' => 'required|in:SD,SMP,SMA,SMK',
             'status' => 'required|in:Negeri,Swasta',
             'province_id' => 'required|exists:provinces,id',
             'city_id' => 'required|exists:regencies,id',
             'district_id' => 'required|exists:districts,id',
             'village_id' => 'required|exists:villages,id',
             'kode_pos' => 'required|string|size:5',
             'no_telp' => 'required|string|max:20',
             'website' => 'nullable|string|max:255',
             'akreditasi' => 'nullable|string|size:1',
             'kepala_sekolah' => 'required|string|max:255',
             'nip_kepala_sekolah' => 'nullable|string|size:18',
             'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
         ]);
 
         if ($validator->fails()) {
             return redirect()->back()
                 ->withErrors($validator)
                 ->withInput();
         }
 
         // Begin database transaction
         DB::beginTransaction();
 
         try {
             // Create user
             $user = User::create([
                 'name' => $request->name,
                 'email' => $request->email,
                 'password' => Hash::make($request->password),
                 'alamat' => $request->alamat,
                 'no_hp' => $request->no_hp,
                 'role' => 'sekolah',
                 'email_verified_at' => null, // Email not verified yet
             ]);
 
             // Handle file upload if provided
             $fotoPath = null;
             if ($request->hasFile('foto')) {
                 $fotoPath = $request->file('foto')->store('sekolah_foto', 'public');
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
                 'is_active' => false, // Default inactive until verified and approved
             ]);
 
             // Generate OTP code
             $otp = $this->generateOTPCode($user);
             
             // Send OTP via email
             Mail::to($user->email)->send(new SchoolRegistrationOTP($user, $otp));
 
             DB::commit();
 
             // Flash notification
             session()->flash('success', 'Pendaftaran sekolah berhasil! Silahkan periksa email untuk melakukan verifikasi akun.');
             
             // Redirect to OTP verification page
             return redirect()->route('school.verify.otp.form', ['email' => $user->email]);
 
         } catch (\Exception $e) {
             DB::rollback();
             
             return redirect()->back()
                 ->withInput()
                 ->withErrors(['error' => 'Terjadi kesalahan saat mendaftarkan sekolah: ' . $e->getMessage()]);
         }
     }
 

    /**
     * Generate a new OTP code for the user
     */
    
    protected function generateOTPCode(User $user)
    {
        // Generate a 6-digit OTP code
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store the OTP in the database with expiration time (15 minutes)
        DB::table('otp_codes')->updateOrInsert(
            ['user_id' => $user->id],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(15),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
        
        return $otp;
    }

    /**
     * Show OTP verification form
     */
    public function showOtpVerificationForm(Request $request)
    {
        $email = $request->email;
        return view('auth.verify-otp', compact('email'));
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6'
        ]);
        
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }
        
        $otpData = OtpCode::where('user_id', $user->id)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();
            
        if (!$otpData) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kadaluarsa.']);
        }
        
        // OTP is valid, mark user as verified
        $user->email_verified_at = now();
        $user->save();
        
        // Delete used OTP
        $otpData->delete();
        
        // Flash notification
        session()->flash('success', 'Verifikasi berhasil! Akun Anda sedang menunggu aktivasi dari admin.');
        
        // Redirect to login page
        return redirect()->route('login');
    }

    /**
     * Resend OTP code
     */
    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);
        
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }
        
        // Check if OTP was sent within last 2 minutes
        $lastOtp = OtpCode::where('user_id', $user->id)
            ->where('created_at', '>', now()->subMinutes(2))
            ->first();
            
        if ($lastOtp) {
            return back()->withErrors(['otp' => 'Harap tunggu 2 menit sebelum meminta kode OTP baru.']);
        }
        
        // Generate and send new OTP
        $otp = $this->generateOTPCode($user);
        $user->notify(new SchoolRegistrationOTP($otp));
        
        // Flash notification
        session()->flash('success', 'Kode OTP baru telah dikirim ke email Anda.');
        
        return back();
    }

    /**
     * Get cities based on province (for AJAX)
     */
    public function getCities(Request $request)
    {
        $cities = \App\Models\Regency::where('province_id', $request->province_id)
            ->get();
        return response()->json($cities);
    }

    /**
     * Get districts based on city (for AJAX)
     */
    public function getDistricts(Request $request)
    {
        $districts = \App\Models\District::where('regency_id', $request->city_id)
            ->get();
        return response()->json($districts);
    }

    /**
     * Get villages based on district (for AJAX)
     */
    public function getVillages(Request $request)
    {
        $villages = \App\Models\Village::where('district_id', $request->district_id)
            ->get();
        return response()->json($villages);
    }
}