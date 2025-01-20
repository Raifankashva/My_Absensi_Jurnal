<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoToDataGuruAndSiswa extends Migration
{
    public function up()
    {
        Schema::table('data_guru', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('nama_lengkap');
        });

        Schema::table('data_siswa', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('nama_lengkap');
        });
    }

    public function down()
    {
        Schema::table('data_guru', function (Blueprint $table) {
            $table->dropColumn('foto');
        });

        Schema::table('data_siswa', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
}