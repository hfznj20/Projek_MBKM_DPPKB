<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Datapenduduk extends Model
{
    protected $table = 'datapenduduk';
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nik', 'nama_lengkap', 'kecamatan', 'kelurahan', 'RT', 'RW', 'TTL', 'jenis_kelamin', 'no_telepon', 'jalan', 'nik_tpk'
    ];

    // Accessor untuk menghitung usia secara otomatis
    public function getUsiaAttribute()
    {
        return Carbon::parse($this->TTL)->age;
    }
}
