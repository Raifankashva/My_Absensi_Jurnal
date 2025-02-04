<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('sekolah_id');
            $table->unsignedBigInteger('kelas_id');
            $table->date('attendance_date');
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa', 'terlambat'])->default('alfa');
            $table->string('check_in_photo')->nullable();
            $table->string('check_out_photo')->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('is_validated')->default(false);
            $table->timestamps();

            $table->unique(['siswa_id', 'attendance_date']);
            $table->foreign('siswa_id')->references('id')->on('data_siswas')->onDelete('cascade');
            $table->foreign('sekolah_id')->references('id')->on('sekolahs')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}