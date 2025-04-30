<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFasilitasSekolahTable extends Migration
{
    public function up()
    {
        Schema::create('fasilitas_sekolah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->string('nama_fasilitas');
            $table->enum('kategori', ['Akademik', 'Olahraga', 'Umum', 'Teknologi', 'Kesehatan']);
            $table->integer('jumlah')->default(0);
            $table->enum('kondisi', ['Baik', 'Cukup', 'Perlu Perbaikan'])->default('Baik');
            $table->text('deskripsi')->nullable();
            $table->string('foto_fasilitas')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fasilitas_sekolah');
    }
}
