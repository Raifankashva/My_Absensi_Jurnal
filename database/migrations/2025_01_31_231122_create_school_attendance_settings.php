<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolAttendanceSettings extends Migration
{
    public function up()
    {
        Schema::create('school_attendance_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->string('token', 32)->unique(); // Token for school-specific access
            $table->time('jam_masuk');
            $table->time('batas_telat');
            $table->time('jam_pulang');
            $table->json('hari_aktif'); // Store active days [1,2,3,4,5] (1=Monday)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('school_attendance_settings');
    }
}
