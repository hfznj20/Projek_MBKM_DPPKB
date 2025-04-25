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
        Schema::create('_b_a_d_u_t_a', function (Blueprint $table) {
            $table->id('nik'); // Nomor Induk Kependudukan
$table->integer('berat_badan'); // BB saat lahir (dalam gram)
$table->integer('tinggi_badan'); // TB saat lahir (dalam cm)
$table->integer('urutan_anak'); // Anak ke-berapa
$table->string('umur_kehamilan_saat_lahir'); // Misal: "38 minggu"
$table->enum('asi_eksklusif', ['ya', 'tidak']); // Pemberian ASI eksklusif
$table->enum('imunisasi_hepatitis_b', ['lengkap', 'tidak lengkap']); // Status imunisasi Hepatitis B
$table->enum('paparan_rokok', ['ya', 'tidak']); // Terpapar asap rokok
$table->string('kondisi_kesehatan_anak'); // KKA - ringkasan kondisi
$table->decimal('longitude', 10, 7); // Koordinat geografis
$table->decimal('latitude', 10, 7);
$table->date('tanggal_kehadiran_posyandu'); // Kehadiran ke Posyandu
$table->string('partisipasi_penyuluhan'); // Mengikuti penyuluhan (jenis atau status)
$table->string('akses_fasilitas_bantuan'); // Misal: "PKH", "BPJS", dsb.
$table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_b_a_d_u_t_a');
    }
};
