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
            $table->foreignId('guru_id')->constrained('data_guru')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('mata_pelajaran');
            $table->string('materi_pembelajaran');
            $table->text('catatan_kegiatan');
            $table->text('capaian_pembelajaran')->nullable();
            $table->integer('jumlah_siswa_hadir');
            $table->integer('jumlah_siswa_tidak_hadir')->default(0);
            $table->text('keterangan_ketidakhadiran')->nullable();
            $table->text('rencana_pembelajaran_selanjutnya')->nullable();
            $table->string('tanda_tangan'); // Akan menyimpan path/url dari gambar tanda tangan
            $table->enum('status', ['draft', 'submitted', 'verified'])->default('draft');
            $table->timestamp('waktu_submit')->nullable();
            $table->timestamps();
            
            // Tambahan index untuk performa query
            $table->index(['tanggal', 'guru_id']);
            $table->index(['kelas_id', 'tanggal']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('jurnal_guru');
    }
}