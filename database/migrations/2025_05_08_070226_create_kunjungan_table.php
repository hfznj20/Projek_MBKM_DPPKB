<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->string('penduduk_nik', 16); // disamakan dengan kolom nik di tabel penduduk
            $table->date('tanggal_kunjungan');
            $table->float('berat_badan');
            $table->float('tinggi_badan');
            $table->string('menggunakan_alat_kontrasepsi')->nullable();
            $table->string('sumber_air_minum')->nullable();
            $table->string('asi_eksklusif')->nullable();
            $table->string('imunisasi_hepatitis_B')->nullable();
            $table->string('merokok_terpapar')->nullable();
            $table->string('mengisi_KKA')->nullable();
            $table->string('kehadiran_posyandu')->nullable();
            $table->string('penyuluhan_KIE')->nullable();
            $table->string('fasilitas_bantuan_sosial')->nullable();
            $table->timestamps();

            // FOREIGN KEY: pastikan kolom nik cocok dengan penduduk.nik
            $table->foreign('penduduk_nik')
                  ->references('nik')
                  ->on('penduduk')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};
