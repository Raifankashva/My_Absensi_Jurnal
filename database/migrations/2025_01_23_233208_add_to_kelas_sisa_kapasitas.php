<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToKelasSisaKapasitas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('kelas', function (Blueprint $table) {
        $table->integer('sisa_kapasitas')->default(0);
    });
}

public function down()
{
    Schema::table('kelas', function (Blueprint $table) {
        $table->dropColumn('sisa_kapasitas');
    });
}
}
