<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemeliharaanFasilitasTable extends Migration
{
    public function up()
    {
        Schema::create('pemeliharaan_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fasilitas_sekolah_id')->constrained('fasilitas_sekolah')->onDelete('cascade');
            $table->date('tanggal_pemeliharaan');
            $table->enum('jenis_pemeliharaan', ['Rutin', 'Darurat', 'Perbaikan Besar']);
            $table->enum('status', ['Selesai', 'Proses', 'Tertunda'])->default('Proses');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemeliharaan_fasilitas');
    }
}
