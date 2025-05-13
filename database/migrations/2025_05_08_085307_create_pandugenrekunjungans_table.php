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
        Schema::create('pandugenre_kunjungans', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16);
            $table->foreign('nik')->references('nik')->on('penduduk')->onDelete('cascade');
            $table->date('tanggal_kunjungan');
            $table->float('berat_badan');
            $table->float('tinggi_badan');
            $table->string('terapi_gizi')->nullable();
            $table->string('terapi_psikososial')->nullable();
            $table->string('kunjungan_rumah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pandugenrekunjungans');
    }
};
