<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToSekolahs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('sekolahs', function (Blueprint $table) {
        $table->integer('total_siswa')->default(0);
    });
}

public function down()
{
    Schema::table('sekolahs', function (Blueprint $table) {
        $table->dropColumn('total_siswa');
    });
}
}
