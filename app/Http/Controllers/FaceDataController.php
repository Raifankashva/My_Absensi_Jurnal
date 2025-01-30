<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSetting;
use App\Models\ScheduleTemplate;
use App\Models\Holiday;
use App\Models\Attendance;
use App\Models\FaceData;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FaceDataController extends Controller
{
    public function index()
    {
        $students = DataSiswa::where('sekolah_id', auth()->user()->sekolah_id)
            ->with('faceData')
            ->get();
        return view('attendance.face.index', compact('students'));
    }

    public function create(DataSiswa $student)
    {
        return view('attendance.face.create', compact('student'));
    }

    public function store(Request $request, DataSiswa $student)
    {
        $request->validate([
            'foto_wajah' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Process and store face image
        $image = $request->file('foto_wajah');
        $fileName = time() . '_' . $student->id . '.' . $image->getClientOriginalExtension();
        
        // Resize image for consistency
        $img = Image::make($image->getRealPath());
        $img->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        // Save processed image
        Storage::put('public/faces/' . $fileName, $img->encode());
        
        // Generate face encoding using Python script
        $pythonScript = base_path('python/generate_encoding.py');
        $imagePath = storage_path('app/public/faces/' . $fileName);
        $encoding = shell_exec("python3 {$pythonScript} {$imagePath}");

        if (!$encoding) {
            Storage::delete('public/faces/' . $fileName);
            return back()->with('error', 'Tidak dapat mendeteksi wajah pada foto');
        }

        FaceData::create([
            'data_siswa_id' => $student->id,
            'face_encoding' => $encoding,
            'foto_wajah' => $fileName,
            'is_active' => true
        ]);

        return redirect()->route('face.index')
            ->with('success', 'Data wajah berhasil disimpan');
    }
}