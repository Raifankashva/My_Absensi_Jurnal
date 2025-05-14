<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hari_libur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->string('keterangan');
            $table->timestamps();
            
            $table->unique(['sekolah_id', 'tanggal']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('hari_libur');
    }
};