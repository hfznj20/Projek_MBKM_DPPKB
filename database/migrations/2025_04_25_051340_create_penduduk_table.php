<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->integer('NIK_TPK');
            $table->string('nama_lengkap');
            $table->id('NIK');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->integer('RT');
            $table->integer('RW');
            $table->string('jalan');
            $table->date('tanggal_lahir');
            $table->integer('no_telepon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduk_');
    }
};
