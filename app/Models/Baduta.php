<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baduta extends Model
{
    use HasFactory;

    protected $table = 'baduta';

    protected $fillable = [
        'penduduk_nik',  // NIK bayi
        'penduduk_ibu_nik',  // NIK ibu
        'jumlah_anak_kandung',
        'tanggal_lahir_anak_terakhir',
        'berat_badan',
        'tinggi_badan',
        'urutan_anak',
        'umur_kehamilan_saat_lahir',
        'menggunakan_alat_kontrasepsi',
        'sumber_air_minum',
        'fasilitas_BAB',
        'asi_eksklusif',
        'imunisasi_hepatitis_B',
        'meerokok_terpapar',
        'mengisi_KKA',
        'longitude',
        'latitude',
        'kehadiran_posyandu',
        'penyuluhan_KIE',
        'fasilitas_bantuan_sosial',
        'stunting'
    ];

    // Relasi ke Penduduk (bayi)
    public function anak()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_nik', 'nik');
    }

    // Relasi ke Penduduk (ibu)
    public function ibu()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_ibu_nik', 'nik');
    }
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_nik', 'nik');
    }

}
