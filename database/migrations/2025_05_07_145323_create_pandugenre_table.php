<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanduGenreTable extends Migration
{
    public function up()
    {
        Schema::create('pandu_genres', function (Blueprint $table) {
            $table->id();
            // Tambahkan kolom dulu
            $table->string('nik', 16);
            $table->foreign('nik')->references('nik')->on('penduduk')->onDelete('cascade');
            $table->string('terapi_gizi')->nullable();
            $table->string('terapi_psikososial')->nullable();
            $table->string('kunjungan_rumah')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pandu_genres');
    }
}
