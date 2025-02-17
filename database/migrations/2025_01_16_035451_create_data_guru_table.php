<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataGuruTable extends Migration
{
    public function up()
    {
        Schema::create('data_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->string('nip', 18)->unique()->nullable();
            $table->string('nuptk', 16)->unique()->nullable(); 
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nik', 16)->unique();
            $table->enum('status_kepegawaian', ['PNS', 'PPPK', 'Honorer', 'GTY', 'GTT']);
            $table->string('pendidikan_terakhir');
            $table->string('jurusan_pendidikan');
            $table->string('alamat');
            $table->string('no_hp');
            $table->date('tmt_kerja'); 
            $table->json('mata_pelajaran'); 
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('data_guru');
    }
}
