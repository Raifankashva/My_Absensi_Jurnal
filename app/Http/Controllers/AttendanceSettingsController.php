<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSetting;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttendanceSettingsController extends Controller
{
    /**
     * Display the attendance settings form
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all schools
        $sekolahs = Sekolah::all();

        // Fetch existing attendance settings (if any)
        $attendanceSettings = AttendanceSetting::first();

        return view('attendance.settings', [
            'sekolahs' => $sekolahs,
            'settings' => $attendanceSettings
        ]);
    }

    /**
     * Update or create attendance settings
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'late_threshold' => 'nullable|date_format:H:i',
            'attendance_type' => 'required|in:qr,manual,both',
            'is_active' => 'sometimes|boolean',
            'attendance_token' => 'nullable|string|max:255'
        ]);

        // If no token provided, generate a random token
        $validatedData['attendance_token'] = $request->input('attendance_token') 
            ?? Str::random(20);

        // Check if settings already exist for this school
        $existingSettings = AttendanceSetting::where('sekolah_id', $validatedData['sekolah_id'])->first();

        if ($existingSettings) {
            // Update existing settings
            $existingSettings->update($validatedData);
        } else {
            // Create new settings
            AttendanceSetting::create($validatedData);
        }

        // Redirect back with success message
        return redirect()->route('attendance.settings.index')
            ->with('success', 'Pengaturan absensi berhasil diperbarui.');
    }

    /**
     * Generate a new attendance token
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateToken(Request $request)
    {
        // Validate school ID
        $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id'
        ]);

        // Generate a new random token
        $newToken = Str::random(20);

        // Update the token for the specific school
        $settings = AttendanceSetting::where('sekolah_id', $request->sekolah_id)->first();

        if ($settings) {
            $settings->update([
                'attendance_token' => $newToken
            ]);

            return response()->json([
                'token' => $newToken,
                'message' => 'Token baru berhasil dibuat.'
            ]);
        }

        return response()->json([
            'message' => 'Pengaturan tidak ditemukan.'
        ], 404);
    }

    /**
     * Deactivate attendance settings
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deactivate(Request $request)
    {
        $request->validate([
            'sekolah_id' => 'required|exists:sekolahs,id'
        ]);

        $settings = AttendanceSetting::where('sekolah_id', $request->sekolah_id)->first();

        if ($settings) {
            $settings->update(['is_active' => false]);

            return redirect()->route('attendance.settings.index')
                ->with('success', 'Pengaturan absensi dinonaktifkan.');
        }

        return redirect()->route('attendance.settings.index')
            ->with('error', 'Pengaturan tidak ditemukan.');
    }
}