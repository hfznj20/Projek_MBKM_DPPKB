<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('catin', function (Blueprint $table) {
            $table->id();

            // Relasi ke penduduk: pasangan pria dan wanita
            $table->string('nik_catin1', 16);
            $table->string('nik_catin2', 16);
            $table->foreign('nik_catin1')->references('nik')->on('penduduk')->onDelete('cascade');
            $table->foreign('nik_catin2')->references('nik')->on('penduduk')->onDelete('cascade');
            
            // Tanggal pernikahan
            $table->date('tanggal_pernikahan');
            
            // Data kesehatan Catin
            $table->integer('tinggi_badan');
            $table->integer('berat_badan');
            $table->integer('indeks_massa_tubuh');
            $table->integer('kadar_hemoglobin');
            $table->integer('LILA');
            
            $table->text('menggunakan_alat_kontrasepsi')->nullable();
            $table->text('catin_wanita_merokok_terpapar')->nullable();
            $table->text('catin_pria_merokok_terpapar')->nullable();
            $table->text('sumber_air_minum')->nullable();
            $table->text('fasilitas_BAB')->nullable();
            $table->decimal('longitude', 10, 7);
            $table->decimal('latitude', 10, 7);
            $table->text('mendapatkan_tablet_tambah_darah')->nullable();
            $table->text('meminum_table_tambah_darah')->nullable();
            $table->text('penyuluhan_KIE')->nullable();
            $table->text('fasilitas_layanan_rujukan')->nullable();
            $table->text('fasilitas_bantuan_sosial')->nullable();
            // $table->text('stunting');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('catin');
    }
};
