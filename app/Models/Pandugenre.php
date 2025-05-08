<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanduGenre extends Model
{
    use HasFactory;

    protected $table = 'pandu_genres';

    protected $fillable = [
        'nik',
        'terapi_gizi',
        'terapi_psikososial',
        'kunjungan_rumah',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'nik', 'nik');
    }
}
