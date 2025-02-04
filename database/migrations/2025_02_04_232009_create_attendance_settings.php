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
            $table->unsignedBigInteger('sekolah_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->time('late_threshold')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('attendance_token')->nullable();
            $table->enum('attendance_type', ['qr', 'manual', 'both'])->default('both');
            $table->timestamps();

            $table->foreign('sekolah_id')->references('id')->on('sekolahs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance_settings');
    }
}