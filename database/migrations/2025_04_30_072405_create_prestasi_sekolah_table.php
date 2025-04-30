<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestasiSekolahTable extends Migration
{
    public function up()
    {
        Schema::create('prestasi_sekolah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->foreignId('guru_id')->nullable()->constrained('data_guru')->onDelete('set null');
            $table->foreignId('siswa_id')->nullable()->constrained('data_siswa')->onDelete('set null');
            $table->string('nama_prestasi');
            $table->enum('tingkat', ['Sekolah', 'Kecamatan', 'Kota', 'Provinsi', 'Nasional', 'Internasional']);
            $table->string('penyelenggara')->nullable();
            $table->year('tahun');
            $table->text('deskripsi')->nullable();
            $table->json('foto_prestasi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prestasi_sekolah');
    }
}
