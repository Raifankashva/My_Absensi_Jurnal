<?php

namespace App\Http\Controllers;

use App\Models\JadwalAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalAbsensiController extends Controller
{
    public function index($sekolahId)
    {
        $jadwal = JadwalAbsensi::where('sekolah_id', $sekolahId)->get();
        return response()->json($jadwal);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sekolah_id' => 'required|exists:sekolahs,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'status' => 'in:aktif,libur',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        // Cek apakah jadwal untuk hari tersebut sudah ada
        $existingJadwal = JadwalAbsensi::where('sekolah_id', $request->sekolah_id)
            ->where('hari', $request->hari)
            ->first();

        if ($existingJadwal) {
            return response()->json([
                'message' => 'Jadwal untuk hari ini sudah ada'
            ], 400);
        }

        $jadwal = JadwalAbsensi::create($validator->validated());

        return response()->json($jadwal, 201);
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalAbsensi::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'in:aktif,libur',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $jadwal->update($validator->validated());

        return response()->json($jadwal);
    }

    public function destroy($id)
    {
        $jadwal = JadwalAbsensi::findOrFail($id);
        $jadwal->delete();

        return response()->json(['message' => 'Jadwal berhasil dihapus']);
    }

    public function getHariLibur($sekolahId)
    {
        $hariLibur = JadwalAbsensi::where('sekolah_id', $sekolahId)
            ->where('status', 'libur')
            ->get();

        return response()->json($hariLibur);
    }
}