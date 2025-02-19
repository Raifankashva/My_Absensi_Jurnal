<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePergantianJadwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pergantian_jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained('jadwal_pelajaran')->onDelete('cascade');
            $table->foreignId('guru_pengganti_id')->constrained('data_guru')->onDelete('cascade');
            $table->date('tanggal_pengganti');
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->text('alasan');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pergantian_jadwal');
    }
}
