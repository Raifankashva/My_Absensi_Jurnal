<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuanganPhotosTable extends Migration
{
    public function up()
    {
        Schema::create('ruangan_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruangan_id')->constrained()->onDelete('cascade');
            $table->string('path'); // path file foto
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ruangan_photos');
    }
}