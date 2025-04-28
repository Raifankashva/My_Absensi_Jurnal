<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\DataGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KelasExport;
use PDF;

class KelasSekolahController extends Controller
{
    public function index(Request $request)
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Start query with school filter automatically applied
        $query = Kelas::with('sekolah', 'siswa')
            ->where('sekolah_id', $userSchool->id);
        
        // Additional filters
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }
        
        $kelas = $query->latest()->paginate(10);
        $kelas->appends($request->query());
        
        return view('kelassekolah.index', compact('kelas', 'userSchool'));
    }

    public function create()
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Get only teachers from the same school who are not already assigned as wali kelas
        $guru = DataGuru::where('sekolah_id', $userSchool->id)
                ->whereNotIn('id', function($query) {
                    $query->select('wali_kelas_id')
                          ->from('kelas')
                          ->whereNotNull('wali_kelas_id');
                })
                ->get();
        
        return view('kelassekolah.create', compact('userSchool', 'guru'));
    }

    public function store(Request $request)
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        $validated = $request->validate([
            'nama_kelas' => 'required|string',
            'tingkat' => 'required|string',
            'jurusan' => 'nullable|string',
            'kapasitas' => 'required|integer',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|string',
            'wali_kelas_id' => [
                'nullable',
                'exists:data_guru,id',
                function ($attribute, $value, $fail) {
                    // Check if the teacher is already assigned as wali kelas in another class
                    if ($value) {
                        $existingAssignment = Kelas::where('wali_kelas_id', $value)->first();
                        if ($existingAssignment) {
                            $fail('Guru ini sudah menjadi wali kelas untuk kelas lain.');
                        }
                    }
                },
            ],
        ]);
        
        // Add school_id automatically
        $validated['sekolah_id'] = $userSchool->id;
        
        // Create new class
        Kelas::create($validated);
        return redirect()->route('kelassekolah.index')->with('success', 'Data kelas berhasil ditambahkan');
    }

    public function show($id)
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Find class and ensure it belongs to the user's school
        $kelas = Kelas::where('id', $id)
            ->where('sekolah_id', $userSchool->id)
            ->with('sekolah', 'siswa', 'waliKelas') // eager load waliKelas relationship
            ->firstOrFail();
            
        if ($kelas) {
            $kelas->updateRemainingCapacity();
            return view('kelassekolah.show', compact('kelas'));
        }
        
        return redirect()->route('kelassekolah.index')->with('error', 'Data kelas tidak ditemukan');
    }

    public function edit($id)
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Find class and ensure it belongs to the user's school
        $kelas = Kelas::where('id', $id)
            ->where('sekolah_id', $userSchool->id)
            ->firstOrFail();
            
        // Get only teachers from the same school who are not already assigned as wali kelas
        // excluding the current wali kelas of this class (if any)
        $guru = DataGuru::where('sekolah_id', $userSchool->id)
                ->where(function($query) use ($kelas) {
                    $query->whereNotIn('id', function($subquery) {
                        $subquery->select('wali_kelas_id')
                                ->from('kelas')
                                ->whereNotNull('wali_kelas_id');
                    })
                    ->orWhere('id', $kelas->wali_kelas_id); // Include current wali kelas in the options
                })
                ->get();
        
        return view('kelassekolah.edit', compact('kelas', 'userSchool', 'guru'));
    }

    public function update(Request $request, $id)
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Find class and ensure it belongs to the user's school
        $kelas = Kelas::where('id', $id)
            ->where('sekolah_id', $userSchool->id)
            ->firstOrFail();
            
        $validated = $request->validate([
            'nama_kelas' => 'required|string',
            'tingkat' => 'required|string',
            'jurusan' => 'nullable|string',
            'kapasitas' => 'required|integer',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|string',
            'wali_kelas_id' => [
                'nullable',
                'exists:data_guru,id',
                function ($attribute, $value, $fail) use ($kelas) {
                    // Check if the teacher is already assigned as wali kelas in another class
                    if ($value) {
                        $existingAssignment = Kelas::where('wali_kelas_id', $value)
                                                   ->where('id', '!=', $kelas->id)
                                                   ->first();
                        if ($existingAssignment) {
                            $fail('Guru ini sudah menjadi wali kelas untuk kelas lain.');
                        }
                    }
                },
            ],
        ]);
        
        // School ID cannot be changed, always use the logged-in user's school
        $validated['sekolah_id'] = $userSchool->id;
        
        // Update the class record
        $kelas->update($validated);
        return redirect()->route('kelassekolah.index')->with('success', 'Data kelas berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Find class and ensure it belongs to the user's school
        $kelas = Kelas::where('id', $id)
            ->where('sekolah_id', $userSchool->id)
            ->firstOrFail();
            
        $kelas->delete();
        return redirect()->route('kelassekolah.index')->with('success', 'Data kelas berhasil dihapus');
    }

    public function exportExcel(Request $request)
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Start query with school filter automatically applied
        $query = Kelas::with('sekolah', 'siswa')
            ->where('sekolah_id', $userSchool->id);
        
        // Apply filters
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }
        
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }
        
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        
        // Get data
        $data = $query->get();
        
        // Generate filename
        $fileName = 'data_kelas_' . $userSchool->nama_sekolah;
        
        if ($request->filled('tahun_ajaran')) {
            $fileName .= '_' . $request->tahun_ajaran;
        }
        
        if ($request->filled('semester')) {
            $fileName .= '_' . $request->semester;
        }
        
        $fileName .= '.xlsx';
        
        // Download Excel file
        return Excel::download(new KelasExport($data), $fileName);
    }
    
    /**
     * Export data kelas to PDF
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportPdf(Request $request)
    {
        // Get current user's school
        $userSchool = Sekolah::where('user_id', Auth::id())->first();
        
        if (!$userSchool) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke data sekolah');
        }
        
        // Start query with school filter automatically applied
        $query = Kelas::with('sekolah', 'siswa')
            ->where('sekolah_id', $userSchool->id);
        
        // Apply filters
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }
        
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }
        
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        
        // Get data
        $data = $query->get();
        
        // Generate filename
        $fileName = 'data_kelas_' . $userSchool->nama_sekolah;
        
        if ($request->filled('tahun_ajaran')) {
            $fileName .= '_' . $request->tahun_ajaran;
        }
        
        if ($request->filled('semester')) {
            $fileName .= '_' . $request->semester;
        }
        
        $fileName .= '.pdf';
        
        // Get filter values for title display
        $tahunAjaran = $request->filled('tahun_ajaran') ? $request->tahun_ajaran : 'Semua Tahun Ajaran';
        $semester = $request->filled('semester') ? $request->semester : 'Semua Semester';
        $tingkat = $request->filled('tingkat') ? $request->tingkat : 'Semua Tingkat';
        
        // Load PDF view
        $pdf = PDF::loadView('exports.kelas_pdf', [
            'data' => $data,
            'sekolah' => $userSchool,
            'tahunAjaran' => $tahunAjaran,
            'semester' => $semester,
            'tingkat' => $tingkat
        ]);
        
        // Download PDF file
        return $pdf->download($fileName);
    }
}