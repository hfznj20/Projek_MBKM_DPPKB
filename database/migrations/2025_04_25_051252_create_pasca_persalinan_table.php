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
        Schema::create('pasca_persalinan', function (Blueprint $table) {
            $table->id('NIK');
            $table->string('cara_persalinan');
            $table->string('penolong_persalinan');
            $table->string('pemberian_penyuluhan_KIE');
            $table->string('komplikasi_masa_nifas');
            $table->integer('IMD');
            $table->string('keadaan_bayi');
            $table->string('tempat_jamban');
            $table->string('tempat_persalinan');
            $table->string('akses_air_minum');
            $table->string('alasan_ber_KB');
            $table->string('metode_berKB');
            $table->string('pengunaan_KB_persalinan');
            $table->integer('tanggal_kunjungan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasca_persalinan');
    }
};
