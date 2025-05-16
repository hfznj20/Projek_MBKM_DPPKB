<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $table = 'kunjungan'; // atau 'kunjungans' tergantung nama tabel
    protected $fillable = [
        'penduduk_nik',
        'tanggal_kunjungan',
        'berat_badan',
        'tinggi_badan',
        'menggunakan_alat_kontrasepsi',
        'sumber_air_minum',
        'asi_eksklusif',
        'imunisasi_hepatitis_B',
        'merokok_terpapar',
        'mengisi_KKA',
        'kehadiran_posyandu',
        'penyuluhan_KIE',
        'fasilitas_bantuan_sosial',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_nik', 'penduduk_nik');
    }
}
