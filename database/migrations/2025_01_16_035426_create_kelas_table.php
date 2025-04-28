<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasTable extends Migration
{
    public function up()
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->string('nama_kelas');
            $table->string('tingkat');
            $table->string('jurusan')->nullable(); 
            $table->integer('kapasitas');
            $table->string('tahun_ajaran');
            $table->string('semester');
            $table->foreignId('wali_kelas_id')->nullable()->constrained('data_gurus')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelas');
    }
}