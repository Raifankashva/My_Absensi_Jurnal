<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('schedule_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->onDelete('cascade');
            $table->string('nama_template');
            $table->boolean('senin')->default(true);
            $table->boolean('selasa')->default(true);
            $table->boolean('rabu')->default(true);
            $table->boolean('kamis')->default(true);
            $table->boolean('jumat')->default(true);
            $table->boolean('sabtu')->default(false);
            $table->boolean('minggu')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedule_templates');
    }
}
