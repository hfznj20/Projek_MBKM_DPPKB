<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUsiaKehamilanFromBadutaTable extends Migration
{
    public function up()
    {
        Schema::table('baduta', function (Blueprint $table) {
            $table->dropColumn('umur_kehamilan_saat_lahir');
        });
    }

    public function down()
    {
        Schema::table('baduta', function (Blueprint $table) {
            $table->integer('usia_kehamilan')->nullable();
        });
    }
}