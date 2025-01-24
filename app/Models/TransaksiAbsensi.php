<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiAbsensi extends Model
{
    protected $table = 'transaksi_absensi';
    
    protected $fillable = [
        'siswa_id', 'tanggal', 'jam_masuk', 'jam_pulang', 
        'status', 'face_signature_masuk', 'face_signature_pulang',
        'face_match_confidence_masuk', 'face_match_confidence_pulang',
        'lokasi_masuk', 'lokasi_pulang', 'keterangan'
    ];

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class);
    }

    // Method untuk validasi wajah
    public function validateFaceScan($faceScan, $type = 'masuk')
    {
        $siswa = $this->siswa;
        $baseSignature = $siswa->face_signature; // Asumsikan ada kolom signature wajah di tabel siswa

        // Lakukan pencocokan wajah 
        // Implementasi sebenarnya akan menggunakan library face recognition
        $matchConfidence = $this->performFaceMatch($baseSignature, $faceScan);

        // Simpan hasil pencocokan
        if ($type === 'masuk') {
            $this->face_signature_masuk = $faceScan;
            $this->face_match_confidence_masuk = $matchConfidence;
        } else {
            $this->face_signature_pulang = $faceScan;
            $this->face_match_confidence_pulang = $matchConfidence;
        }

        // Tentukan keberhasilan berdasarkan tingkat kepercayaan
        return $matchConfidence > 0.7; // Contoh: cocok jika di atas 70%
    }

    // Metode simulasi pencocokan wajah (akan diganti dengan library sesungguhnya)
    private function performFaceMatch($baseSignature, $inputSignature)
    {
        // Logika pencocokan wajah sebenarnya
        // Ini hanya contoh sederhana
        return similar_text($baseSignature, $inputSignature) / 100;
    }
}