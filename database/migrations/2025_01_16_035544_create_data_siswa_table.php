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
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']);
            $table->string('alamat');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kota');
            $table->string('provinsi');
            $table->string('kode_pos', 5);
            $table->enum('jenis_tinggal', ['Bersama Orang Tua', 'Wali', 'Kost', 'Asrama', 'Panti Asuhan']);
            $table->string('transportasi');
            $table->string('no_hp')->nullable();
            $table->string('email');
            
            // Data Ayah
            $table->string('nama_ayah');
            $table->string('pekerjaan_ayah')->nullable();
            
            // Data Ibu
            $table->string('nama_ibu');
            $table->string('pekerjaan_ibu')->nullable();
            
            // Data Wali (Optional)
            $table->string('nama_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            
            // Data Periodik
            $table->integer('tinggi_badan')->nullable(); // dalam cm
            $table->integer('berat_badan')->nullable(); // dalam kg
            $table->integer('jarak_rumah')->nullable(); // dalam km
            $table->integer('waktu_tempuh')->nullable(); // dalam menit
            
            // Data Program Bantuan
            $table->string('kks')->nullable(); // Kartu Keluarga Sejahtera
            $table->string('kph')->nullable(); // Kartu Program Harapan
            $table->string('kip')->nullable(); // Kartu Indonesia Pintar
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_siswa');
    }
}