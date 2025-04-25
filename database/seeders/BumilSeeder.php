<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BumilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('_b_u_m_i_l_')->insert([
            [
                'nik' => '1234567890123456',
                'usia_kehamilan' => '12 minggu',
                'tuf' => '2025-04-25',
                'jumlah_anak_kandung' => 2,
                'tanggal_lahir_anak_terakhir' => '2020-06-15',
                'tinggi_badan' => 160,
                'bb_sebelum_hamil' => 55,
                'bb_saat_ini' => 60,
                'imt' => 23.4,
                'kadar_hemoglobin' => '12.5 g/dL',
                'lila' => 25,
                'penggunaan_kontrasepsi' => 'IUD',
                'paparan_rokok' => 'tidak',
                'sumber_air' => 'PAM',
                'fasilitas_buang_air' => 'Jamban Sehat',
                'longitude' => -120.1234567,
                'latitude' => -4.5678901,
                'tablet_tambah_darah' => 'ya',
                'riwayat_penyuluhan' => 'Penyuluhan gizi',
                'fasilitas_bantuan' => 'PKH',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan lebih banyak data jika perlu
        ]);
    }
}
