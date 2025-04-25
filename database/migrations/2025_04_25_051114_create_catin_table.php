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
        Schema::create('catin', function (Blueprint $table) {
            $table->id('NIK');
            $table->string('Nama_lengkap');
            $table->string('jenis_kelamin');
            $table->date('tanggal_lahir');
            $table->integer('no_hp');
            $table->string('kecamatan', );
            $table->string('kelurahan', );
            $table->string('RT', );
            $table->string('RW', );
            $table->string('alamat');
            $table->integer('tb_wanita');
            $table->integer('tb_pria');
            $table->integer('kadar_hemogoblin');
            $table->integer('terpapar_rokok_wanita');
            $table->string('sumber_air');
            $table->string('fasilitas_buang_air');
            $table->decimal('longtitude');
            $table->decimal('latitude');
            $table->string('riwayat_tablet_tambah_darah');
            $table->string('penyuluhan');
            $table->string('fasilitas_pelayanan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catin');
    }
};

