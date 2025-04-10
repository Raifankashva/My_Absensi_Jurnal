<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiPelajaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('data_siswa')->onDelete('cascade');
            $table->foreignId('jadwal_pelajaran_id')->constrained('jadwal_pelajaran')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpa', 'Terlambat']);
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->unique(['siswa_id', 'jadwal_pelajaran_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi_pelajaran');
    }
}