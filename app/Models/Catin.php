<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catin extends Model
{
    use HasFactory;

    protected $table = 'catin';

    protected $fillable = [
        'pasangan_pertama_nik',
        'pasangan_kedua_nik',
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
    public function pasanganPertama()
    {
        return $this->belongsTo(Penduduk::class, 'pasangan_pertama_nik', 'nik');
    }

    // Relasi dengan pasangan kedua
    public function pasanganKedua()
    {
        return $this->belongsTo(Penduduk::class, 'pasangan_kedua_nik', 'nik');
    }

    // Relasi dengan data ibu jika ada
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_nik', 'nik');
    }
}
