<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduk';

    protected $primaryKey = 'nik'; // set primary key ke 'nik'
    public $incrementing = false;  // karena nik bukan auto-increment
    protected $keyType = 'string'; // karena nik bertipe string

    protected $fillable = [
        'nik',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'kelurahan',
        'kecamatan',
        'RT',
        'RW',
        'alamat',
        'no_hp',
        'kategori',
    ];

    // Relasi satu ke satu dengan model terkait berdasarkan foreign key 'nik'
    public function baduta()
    {
        return $this->hasOne(Baduta::class, 'penduduk_nik', 'nik');
    }

    public function catin()
    {
        return $this->hasOne(Catin::class, 'penduduk_nik', 'nik');
    }

    public function bumil()
    {
        return $this->hasOne(Bumil::class, 'penduduk_nik', 'nik');
    }

    public function pascaPersalinan()
    {
        return $this->hasOne(Pasper::class, 'penduduk_nik', 'nik');
    }
}
