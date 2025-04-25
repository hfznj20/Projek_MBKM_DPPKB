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
        Schema::create('_b_u_m_i_l_', function (Blueprint $table) {
            $table->id('nik'); // Gunakan string jika ini benar-benar NIK, atau cukup 'id' jika auto increment
$table->string('usia_kehamilan'); // Misal: "12 minggu"
$table->string('tuf'); // Tanggal Ukuran Fundus atau sejenis, mohon konfirmasi istilah
$table->integer('jumlah_anak_kandung');
$table->date('tanggal_lahir_anak_terakhir');
$table->integer('tinggi_badan'); // dalam cm
$table->integer('bb_sebelum_hamil'); // dalam kg
$table->integer('bb_saat_ini'); // dalam kg
$table->decimal('imt', 5, 2); // Indeks Massa Tubuh, lebih tepat pakai decimal
$table->string('kadar_hemoglobin'); // typo: 'hemogoblin' jadi 'hemoglobin'
$table->integer('lila'); // Lingkar Lengan Atas (cm)

$table->string('penggunaan_kontrasepsi');
$table->enum('paparan_rokok', ['ya', 'tidak']);
$table->string('sumber_air');
$table->string('fasilitas_buang_air'); // misalnya "jamban sehat", dll

$table->decimal('longitude', 10, 7);
$table->decimal('latitude', 10, 7);

$table->string('tablet_tambah_darah'); // Bisa pakai enum kalau opsinya pasti
$table->string('riwayat_penyuluhan'); // Bisa diubah ke text jika panjang
$table->string('fasilitas_bantuan'); // Misal: PKH, BPJS, KIS, dll

$table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_b_u_m_i_l_');
    }
};
