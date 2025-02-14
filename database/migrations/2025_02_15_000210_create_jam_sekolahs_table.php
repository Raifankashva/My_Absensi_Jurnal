<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJamSekolahsTable extends Migration
{
    public function up()
    {
        Schema::create('jam_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->time('jam_masuk');
            $table->time('jam_telat');
            $table->time('jam_pulang');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jam_sekolahs');
    }
}

