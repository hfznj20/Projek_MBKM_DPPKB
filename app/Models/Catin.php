<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catin extends Model
{
    use HasFactory;

    protected $table = 'catin';

    protected $fillable = [
        'nik_catin1',
        'nik_catin2',
        'tanggal_pernikahan',
        'tinggi_badan',
        'berat_badan',
        'indeks_massa_tubuh',
        'kadar_hemoglobin',
        'LILA',
        'menggunakan_alat_kontrasepsi',
        'catin_wanita_meerokok_terpapar',
        'catin_pria_meerokok_terpapar',
        'sumber_air_minum',
        'fasilitas_BAB',
        'longitude',
        'latitude',
        'mendapatkan_tablet_tambah_darah',
        'meminum_table_tambah_darah',
        'penyuluhan_KIE',
        'fasilitas_layanan_rujukan',
        'fasilitas_bantuan_sosial',
    ];

    // Relasi dengan pasangan pertama
    public function catin1()
    {
        return $this->belongsTo(Penduduk::class, 'nik_catin1', 'nik');
    }

    // Relasi dengan pasangan kedua
    public function catin2()
    {
        return $this->belongsTo(Penduduk::class, 'nik_catin2', 'nik');
    }

    // Relasi dengan data ibu jika ada
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_nik', 'nik');
    }
}
