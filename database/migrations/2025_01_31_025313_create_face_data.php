<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaceDataTable extends Migration
{
    public function up()
    {
        Schema::create('face_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_siswa_id')->constrained('data_siswa')->onDelete('cascade');
            $table->string('face_encoding'); // Store face encoding data
            $table->string('foto_wajah'); // Store path to face image
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('face_data');
    }
}