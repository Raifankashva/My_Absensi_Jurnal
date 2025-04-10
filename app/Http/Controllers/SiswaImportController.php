<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\DataSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiswaImportController extends Controller
{
    public function index()
    {
        return view('adminsiswa.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        DB::beginTransaction();

        try {
            $import = new SiswaImport();
            Excel::import($import, $request->file('file'));
            
            DB::commit();
            
            return redirect()->route('siswa.import')
                ->with('success', 'Data siswa berhasil diimport. ' . $import->getRowCount() . ' data ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $filePath = storage_path('app/templates/template_import_siswa.xlsx');
        
        if (file_exists($filePath)) {
            return response()->download($filePath, 'template_import_siswa.xlsx');
        }
        
        return redirect()->back()->with('error', 'Template tidak ditemukan');
    }
}