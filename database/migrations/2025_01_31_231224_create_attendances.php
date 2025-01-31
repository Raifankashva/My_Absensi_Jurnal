<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendances extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->foreignId('data_siswa_id')->constrained('data_siswa')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->string('foto_masuk')->nullable(); // Store path to face capture image
            $table->string('foto_pulang')->nullable();
            $table->enum('status_masuk', ['tepat_waktu', 'terlambat', 'alpha'])->nullable();
            $table->enum('status_pulang', ['normal', 'pulang_cepat', 'belum_pulang'])->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();

            // Ensure one attendance record per student per day per school
            $table->unique(['sekolah_id', 'data_siswa_id', 'tanggal']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}