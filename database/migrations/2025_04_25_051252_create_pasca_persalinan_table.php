<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pasca_persalinan', function (Blueprint $table) {
            $table->id();

            // Relasi ke penduduk menggunakan NIK
            $table->string('penduduk_nik', 16);
            $table->foreign('penduduk_nik')->references('nik')->on('penduduk')->onDelete('cascade');

            $table->date('tanggal_persalinan');
            $table->text('tempat_persalinan');
            $table->text('penolong_persalinan');
            $table->text('cara_persalinan');
            $table->text('keadaan_bayi');
            $table->text('menggunakan_alat_kontrasepsi')->nullable();
            $table->text('meerokok_terpapar')->nullable();
            $table->text('sumber_air_minum')->nullable();
            $table->text('fasilitas_BAB')->nullable();
            $table->decimal('longitude', 10, 7);
            $table->decimal('latitude', 10, 7);
            $table->text('mendapatkan_tablet_tambah_darah')->nullable();
            $table->text('meminum_table_tambah_darah')->nullable();
            $table->text('penyuluhan_KIE')->nullable();
            $table->text('fasilitas_layanan_rujukan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pasca_persalinan');
    }
};
