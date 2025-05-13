<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganBumil extends Model
{
    use HasFactory;

    protected $table = 'kunjunganbumil'; // pastikan ini sesuai dengan nama tabel di database

    protected $fillable = [
        'penduduk_nik',
        'tanggal_kunjungan',
        'usia_kehamilan',
        'TUF',
        'tinggi_badan',
        'berat_badan_sebelum_hamil',
        'berat_badan_saat_ini',
        'indeks_massa_tubuh',
        'kadar_hemoglobin',
        'LILA',
        'menggunakan_alat_kontrasepsi',
        'sumber_air_minum',
        'fasilitas_BAB',
        'meerokok_terpapar',
        'mendapatkan_tablet_tambah_darah',
        'meminum_table_tambah_darah',
        'penyuluhan_KIE',
        'fasilitas_layanan_rujukan',
        'fasilitas_bantuan_sosial',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_nik', 'nik');
    }
}
