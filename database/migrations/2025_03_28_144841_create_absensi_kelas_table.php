<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('jadwal_pelajaran_id')->constrained('jadwal_pelajaran')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('data_guru')->onDelete('cascade');
            
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            
            $table->integer('total_siswa')->default(0);
            $table->integer('siswa_hadir')->default(0);
            $table->integer('siswa_tidak_hadir')->default(0);
            $table->integer('siswa_terlambat')->default(0);
            
            $table->enum('status_kelas', ['Terlaksana', 'Diganti', 'Dibatalkan'])->default('Terlaksana');
            
            $table->text('catatan')->nullable();
            
            $table->timestamps();
            
            // Unique constraint to prevent duplicate entries
            $table->unique(['kelas_id', 'jadwal_pelajaran_id', 'tanggal'], 'unique_kelas_jadwal_tanggal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absensi_kelas');
    }
}