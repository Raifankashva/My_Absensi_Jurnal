<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolApprovalController extends Controller
{
    /**
     * Display a listing of pending school registrations
     */
    public function index(Request $request)
    {
        try {
            $query = User::where('role', 'sekolah')->with('sekolah');
            
            // Filter by status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            // Filter by search term
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhereHas('sekolah', function($q) use($request) {
                          $q->where('npsn', 'like', '%' . $request->search . '%');
                      });
            }
            
            $schools = $query->latest()->paginate(10);
            
            return view('admin.school-approvals.index', compact('schools'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Show details of a school registration
     */
    public function show($id)
    {
        try {
            $user = User::where('role', 'sekolah')->findOrFail($id);
            $sekolah = Sekolah::where('user_id', $user->id)->first();
            
            if (!$sekolah) {
                return redirect()->route('school-approvals.index')
                    ->with('error', 'Data sekolah tidak ditemukan');
            }
            
            return view('admin.school-approvals.show', compact('user', 'sekolah'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Approve a school registration
     */
    public function approve($id)
    {
        try {
            DB::beginTransaction();
            
            $user = User::where('role', 'sekolah')->findOrFail($id);
            $user->status = 'approved';
            $user->save();
            
            // Send notification email to school
            // This would be implemented with Laravel's notification system
            
            DB::commit();
            
            return redirect()->route('school-approvals.index')
                ->with('success', 'Pendaftaran sekolah berhasil disetujui');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Reject a school registration
     */
    public function reject(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $validator = Validator::make($request->all(), [
                'rejection_reason' => 'required|string|max:255'
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            
            $user = User::where('role', 'sekolah')->findOrFail($id);
            $user->status = 'rejected';
            $user->rejection_reason = $request->rejection_reason;
            $user->save();
            
            // Send rejection notification email to school
            // This would be implemented with Laravel's notification system
            
            DB::commit();
            
            return redirect()->route('school-approvals.index')
                ->with('success', 'Pendaftaran sekolah berhasil ditolak');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Deactivate an approved school
     */
    public function deactivate(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $validator = Validator::make($request->all(), [
                'deactivation_reason' => 'required|string|max:255'
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            
            $user = User::where('role', 'sekolah')->findOrFail($id);
            $user->status = 'inactive';
            $user->deactivation_reason = $request->deactivation_reason;
            $user->save();
            
            // Send deactivation notification email to school
            // This would be implemented with Laravel's notification system
            
            DB::commit();
            
            return redirect()->route('school-approvals.index')
                ->with('success', 'Akun sekolah berhasil dinonaktifkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Reactivate an inactive or rejected school
     */
    public function reactivate($id)
    {
        try {
            DB::beginTransaction();
            
            $user = User::where('role', 'sekolah')->findOrFail($id);
            $user->status = 'approved';
            $user->save();
            
            // Send reactivation notification email to school
            // This would be implemented with Laravel's notification system
            
            DB::commit();
            
            return redirect()->route('school-approvals.index')
                ->with('success', 'Akun sekolah berhasil diaktifkan kembali');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}