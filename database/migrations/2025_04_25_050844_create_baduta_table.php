<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('baduta', function (Blueprint $table) {
            $table->id();
            // Tambahkan kolom dulu
            $table->string('penduduk_nik', 16);
            $table->string('penduduk_ibu_nik', 16);
            // Foreign key relasi ke tabel penduduk (kolom nik)
            $table->foreign('penduduk_nik')->references('nik')->on('penduduk')->onDelete('cascade');
            $table->foreign('penduduk_ibu_nik')->references('nik')->on('penduduk')->onDelete('cascade');

            $table->integer('jumlah_anak_kandung');
            $table->date('tanggal_lahir_anak_terakhir');
            $table->integer('berat_badan');
            $table->integer('tinggi_badan');
            $table->integer('urutan_anak');
            $table->integer('umur_kehamilan_saat_lahir');
            $table->text('menggunakan_alat_kontrasepsi')->nullable();
            $table->text('sumber_air_minum')->nullable();
            $table->text('fasilitas_BAB')->nullable();
            $table->text('asi_eksklusif')->nullable();
            $table->text('imunisasi_hepatitis_B')->nullable();
            $table->text('meerokok_terpapar')->nullable();
            $table->text('mengisi_KKA')->nullable();
            $table->decimal('longitude', 10, 7);
            $table->decimal('latitude', 10, 7);
            $table->text('kehadiran_posyandu')->nullable();
            $table->text('penyuluhan_KIE')->nullable();
            $table->text('fasilitas_bantuan_sosial')->nullable();
            $table->text('stunting');
            $table->string('niktpk');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('baduta');
    }
};
