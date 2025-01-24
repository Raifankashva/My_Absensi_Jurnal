<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiAbsensiTable extends Migration
{
    public function up()
    {
        Schema::create('transaksi_absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('data_siswa')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->enum('status', ['hadir', 'terlambat', 'izin', 'sakit', 'alfa'])->default('alfa');
            $table->string('face_signature_masuk')->nullable(); // Signature wajah saat absen masuk
            $table->string('face_signature_pulang')->nullable(); // Signature wajah saat absen pulang
            $table->float('face_match_confidence_masuk')->nullable(); // Tingkat kepercayaan pencocokan wajah masuk
            $table->float('face_match_confidence_pulang')->nullable(); // Tingkat kepercayaan pencocokan wajah pulang
            $table->string('lokasi_masuk')->nullable(); // Koordinat lokasi absen masuk
            $table->string('lokasi_pulang')->nullable(); // Koordinat lokasi absen pulang
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi_absensi');
    }
}