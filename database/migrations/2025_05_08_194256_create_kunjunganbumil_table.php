<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('kunjunganbumil', function (Blueprint $table) {
            $table->id();
            $table->string('penduduk_nik', 16);
            $table->date('tanggal_kunjungan');
            $table->integer('usia_kehamilan');
            $table->integer('TUF');
            $table->integer('tinggi_badan');
            $table->integer('berat_badan_sebelum_hamil');
            $table->integer('berat_badan_saat_ini');
            $table->decimal('indeks_massa_tubuh', 5, 2);
            $table->decimal('kadar_hemoglobin', 5, 2);
            $table->decimal('LILA', 5, 2);
            $table->string('menggunakan_alat_kontrasepsi')->nullable();
            $table->string('sumber_air_minum')->nullable();
            $table->string('fasilitas_BAB')->nullable();
            $table->string('meerokok_terpapar')->nullable();
            $table->string('mendapatkan_tablet_tambah_darah')->nullable();
            $table->string('meminum_table_tambah_darah')->nullable();
            $table->string('penyuluhan_KIE')->nullable();
            $table->string('fasilitas_layanan_rujukan')->nullable();
            $table->string('fasilitas_bantuan_sosial')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('penduduk_nik')->references('nik')->on('penduduk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan_bumil');
    }
};
