<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSekolahsTable extends Migration
{
    public function up()
    {
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique(); // Add this line
            $table->string('npsn', 8)->unique(); // Nomor Pokok Sekolah Nasional
            $table->string('nama_sekolah');
            $table->enum('jenjang', ['SD', 'SMP', 'SMA', 'SMK']);
            $table->enum('status', ['Negeri', 'Swasta']);
            $table->string('alamat');
            
            // Foreign keys untuk IndoRegion
            $table->char('province_id', 2);
            $table->char('city_id', 4);
            $table->char('district_id', 7);
            $table->char('village_id', 10);
            
            $table->string('kode_pos', 5);
            $table->string('no_telp');
            $table->string('email')->unique();
            $table->string('website')->nullable();
            $table->string('akreditasi', 1)->nullable();
            $table->string('kepala_sekolah');
            $table->string('nip_kepala_sekolah', 18)->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->boolean('is_active')->default(false); // tambahkan ini

            // Menambahkan foreign key constraints
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
                  $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade') // Or 'restrict' depending on your needs
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sekolahs');
    }
}