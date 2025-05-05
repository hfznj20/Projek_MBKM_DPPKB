<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Manajemen extends Model
{
    protected $table = 'manajemens';
    protected $primaryKey = 'NIK';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'NIK', 'nama', 'kecamatan', 'kelurahan', 
    ];

    // Manajemen Model
    public function user()
    {
        return $this->hasOne(User::class, 'NIK', 'NIK');
    }
}