<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolHolidays extends Migration
{
    public function up()
    {
        Schema::create('school_holidays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('school_holidays');
    }
}
