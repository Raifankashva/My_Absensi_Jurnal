<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalGuruTable extends Migration
{
    public function up()
    {
        Schema::create('jurnal_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_pelajaran_id')->constrained('jadwal_pelajaran')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('data_guru')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->date('tanggal');
            $table->text('materi_yang_disampaikan');
            $table->text('catatan_pembelajaran')->nullable();
            $table->integer('jumlah_siswa_hadir');
            $table->integer('jumlah_siswa_tidak_hadir');
            $table->json('data_siswa_tidak_hadir')->nullable(); // Menyimpan detail siswa yang tidak hadir
            $table->enum('status_pertemuan', ['Terlaksana', 'Diganti', 'Dibatalkan'])->default('Terlaksana');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jurnal_guru');
    }
}