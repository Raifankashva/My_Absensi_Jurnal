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
            $table->string('tingkat'); // 1,2,3,4,5,6 untuk SD, 7,8,9 untuk SMP, 10,11,12 untuk SMA/SMK
            $table->string('jurusan')->nullable(); // Untuk SMA/SMK
            $table->integer('kapasitas');
            $table->string('tahun_ajaran');
            $table->string('semester');
            $table->string('wali_kelas')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelas');
    }
}