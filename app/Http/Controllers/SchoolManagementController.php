<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class SchoolManagementController extends Controller
{
    /**
     * Display a listing of schools
     */
    public function index()
    {
        $schools = Sekolah::with('user')->paginate(10);
        return view('admin.schools.index', compact('schools'));
    }

    /**
     * Toggle school account activation status
     */
    public function toggleActivation(Request $request, $id)
    {
        $school = Sekolah::findOrFail($id);
        $user = $school->user;
        
        // Toggle activation status
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Akun sekolah {$school->nama_sekolah} berhasil {$status}.");
    }
}