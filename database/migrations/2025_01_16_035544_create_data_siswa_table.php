<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateDataSiswaTable extends Migration
{
    public function up()
    {
        Schema::create('data_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('nisn', 10)->unique();
            $table->string('nis', 10)->unique();
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['laki-laki', 'Perempuan']);
            $table->string('tmp_lahir');
            $table->date('tgl_lahir');
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']);
            $table->char('province_id', 2);
            $table->char('city_id', 4);
            $table->char('district_id', 7);
            $table->char('village_id', 10);
            $table->string('kode_pos', 5);
            $table->enum('tinggal', ['Ortu', 'Wali', 'Kost', 'Asrama', 'Panti']);
            $table->string('transport');
            $table->string('hp')->nullable();
            
            // Data Orang Tua/Wali
            $table->string('ayah');
            $table->string('email_ayah')->nullable(); // Email Ayah
            $table->string('kerja_ayah')->nullable();
            $table->string('ibu');
            $table->string('email_ibu')->nullable(); // Email Ibu
            $table->string('kerja_ibu')->nullable();
            $table->string('wali')->nullable();
            $table->string('email_wali')->nullable(); // Email Wali
            $table->string('kerja_wali')->nullable();

            // Data Tambahan
            $table->integer('tb')->nullable(); // Tinggi Badan (cm)
            $table->integer('bb')->nullable(); // Berat Badan (kg)
            
            // Program Bantuan
            $table->string('kks')->nullable();
            $table->string('kph')->nullable();
            $table->string('kip')->nullable();
            $table->foreign('province_id')
            ->references('id')
            ->on('provinces')
            ->onDelete('restrict')
            ->onUpdate('cascade');
            
      $table->foreign('city_id')
            ->references('id')
            ->on('regencies')
            ->onDelete('restrict')
            ->onUpdate('cascade');
      
            
      $table->foreign('district_id')
            ->references('id')
            ->on('districts')
            ->onDelete('restrict')
            ->onUpdate('cascade');
            
      $table->foreign('village_id')
            ->references('id')
            ->on('villages')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_siswa');
    }
}
