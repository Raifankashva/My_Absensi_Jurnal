<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaceEncodings extends Migration
{
    public function up()
    {
        Schema::create('face_encodings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_siswa_id')->constrained('data_siswa')->onDelete('cascade');
            $table->binary('encoding_data'); // Store face encoding data
            $table->string('foto_referensi'); // Store path to reference face image
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('face_encodings');
    }
}