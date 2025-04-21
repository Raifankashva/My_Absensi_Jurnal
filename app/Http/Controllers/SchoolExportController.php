<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SchoolExportController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display the export form.
     */
    public function showExportForm()
    {
        $provinces = Province::orderBy('name')->get();
        return view('exports.schools-export-form', compact('provinces'));
    }

    /**
     * Export data to Excel format.
     */
    public function exportExcel(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'province_id' => 'nullable|exists:provinces,id',
            'city_id' => 'nullable|exists:regencies,id',
            'district_id' => 'nullable|exists:districts,id',
            'village_id' => 'nullable|exists:villages,id',
        ]);

        // Build query based on filters
        $query = $this->buildQuery($request);
        $schools = $query->get();

        // Create a new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = [
            'No', 'NPSN', 'Nama Sekolah', 'Jenjang', 'Status', 'Akreditasi',
            'Alamat', 'Provinsi', 'Kota/Kabupaten', 'Kecamatan', 'Kelurahan/Desa', 'Kode Pos',
            'Kepala Sekolah', 'NIP Kepala Sekolah', 'No. Telepon', 'Email', 'Website', 'Status Aktif'
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        // Add data rows
        $row = 2;
        foreach ($schools as $index => $school) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $school->npsn);
            $sheet->setCellValue('C' . $row, $school->nama_sekolah);
            $sheet->setCellValue('D' . $row, $school->jenjang);
            $sheet->setCellValue('E' . $row, $school->status);
            $sheet->setCellValue('F' . $row, $school->akreditasi);
            $sheet->setCellValue('G' . $row, $school->alamat);
            $sheet->setCellValue('H' . $row, $school->province->name ?? '');
            $sheet->setCellValue('I' . $row, $school->city->name ?? '');
            $sheet->setCellValue('J' . $row, $school->district->name ?? '');
            $sheet->setCellValue('K' . $row, $school->village->name ?? '');
            $sheet->setCellValue('L' . $row, $school->kode_pos);
            $sheet->setCellValue('M' . $row, $school->kepala_sekolah);
            $sheet->setCellValue('N' . $row, $school->nip_kepala_sekolah);
            $sheet->setCellValue('O' . $row, $school->no_telp);
            $sheet->setCellValue('P' . $row, $school->email);
            $sheet->setCellValue('Q' . $row, $school->website);
            $sheet->setCellValue('R' . $row, $school->is_active ? 'Aktif' : 'Tidak Aktif');
            $row++;
        }

        // Generate filename
        $filename = 'data_sekolah_' . date('Y-m-d_His') . '.xlsx';
        
        // Create response
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    /**
     * Export data to PDF format.
     */
    public function exportPdf(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'province_id' => 'nullable|exists:provinces,id',
            'city_id' => 'nullable|exists:regencies,id',
            'district_id' => 'nullable|exists:districts,id',
            'village_id' => 'nullable|exists:villages,id',
        ]);

        // Build query based on filters
        $query = $this->buildQuery($request);
        $schools = $query->get();

        // Get location data for the header
        $locations = $this->getLocationNames($request);

        // Generate PDF
        $pdf = PDF::loadView('exports.schools-pdf', compact('schools', 'locations'));

        // Generate filename
        $filename = 'data_sekolah_' . date('Y-m-d_His') . '.pdf';
        
        // Return PDF for download
        return $pdf->download($filename);
    }

    /**
     * Build query based on location filters.
     */
    private function buildQuery(Request $request)
    {
        $query = Sekolah::with(['province', 'city', 'district', 'village']);

        if ($request->filled('province_id')) {
            $query->where('province_id', $request->province_id);
        }

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        if ($request->filled('village_id')) {
            $query->where('village_id', $request->village_id);
        }

        return $query->orderBy('nama_sekolah');
    }

    /**
     * Get location names for PDF header.
     */
    private function getLocationNames(Request $request)
    {
        $locations = [
            'province' => null,
            'city' => null,
            'district' => null,
            'village' => null
        ];

        if ($request->filled('province_id')) {
            $locations['province'] = Province::find($request->province_id)->name;
        }

        if ($request->filled('city_id')) {
            $locations['city'] = Regency::find($request->city_id)->name;
        }

        if ($request->filled('district_id')) {
            $locations['district'] = District::find($request->district_id)->name;
        }

        if ($request->filled('village_id')) {
            $locations['village'] = Village::find($request->village_id)->name;
        }

        return $locations;
    }

    /**
     * Get cities by province (for AJAX requests).
     */
    public function getCities($provinceId)
    {
        $cities = Regency::where('province_id', $provinceId)->orderBy('name')->get();
        return response()->json($cities);
    }

    /**
     * Get districts by city (for AJAX requests).
     */
    public function getDistricts($cityId)
    {
        $districts = District::where('regency_id', $cityId)->orderBy('name')->get();
        return response()->json($districts);
    }

    /**
     * Get villages by district (for AJAX requests).
     */
    public function getVillages($districtId)
    {
        $villages = Village::where('district_id', $districtId)->orderBy('name')->get();
        return response()->json($villages);
    }
}