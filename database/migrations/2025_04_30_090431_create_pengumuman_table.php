<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengumumanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::create('pengumuman', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
        $table->string('judul');
        $table->text('isi');
        $table->string('kategori', 100);
        $table->date('tanggal_mulai');
        $table->date('tanggal_berakhir')->nullable();
        $table->string('lampiran')->nullable();
        $table->enum('status', ['aktif', 'arsip'])->default('aktif');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengumuman');
    }
}
