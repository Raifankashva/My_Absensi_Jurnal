<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('attendance_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->time('jam_masuk');
            $table->time('batas_telat');
            $table->time('jam_pulang');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance_settings');
    }
}