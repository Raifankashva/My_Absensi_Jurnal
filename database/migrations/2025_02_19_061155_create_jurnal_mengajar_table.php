<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalMengajarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_mengajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained('jadwal_pelajaran')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('data_guru')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('materi');
            $table->text('kegiatan');
            $table->text('evaluasi')->nullable();
            $table->integer('jumlah_siswa_hadir');
            $table->integer('jumlah_siswa_tidak_hadir');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('jurnal_mengajar');
    }
}
