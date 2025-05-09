<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pandugenrekunjungan extends Model
{    
    use HasFactory;
    protected $table = 'pandugenre_kunjungans';

    protected $fillable = [
        'nik',
        'tanggal_kunjungan',
        'berat_badan',
        'tinggi_badan',
        'terapi_gizi',
        'terapi_psikososial',
        'kunjungan_rumah',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'nik', 'nik');
    }
    public function panduGenre()
    {
        return $this->belongsTo(Pandugenre::class);
    }
}
