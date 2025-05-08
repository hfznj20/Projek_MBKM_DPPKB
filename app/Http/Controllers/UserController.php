<?php

namespace App\Http\Controllers;
use App\Models\Penduduk;
use App\Models\Bumil;
use App\Models\Baduta;
use App\Models\Catin;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function indexStuntingTPK()
    {
        $stuntingData = collect();

        $baduta = Baduta::with('penduduk')
            ->where('stunting', 'Ya')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nik' => $item->penduduk?->nik ?? '-',
                    'nama' => $item->penduduk?->nama ?? 'Tidak Ditemukan',
                    'kecamatan' => $item->penduduk?->kecamatan ?? 'Tidak Ditemukan',
                    'kelurahan' => $item->penduduk?->kelurahan ?? 'Tidak Ditemukan',
                    'statusStunting' => 'Baduta',
                ];
            });

        $bumil = Bumil::with('penduduk')
            ->where('stunting', 'Ya')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nik' => $item->penduduk?->nik ?? '-',
                    'nama' => $item->penduduk?->nama ?? 'Tidak Ditemukan',
                    'kecamatan' => $item->penduduk?->kecamatan ?? 'Tidak Ditemukan',
                    'kelurahan' => $item->penduduk?->kelurahan ?? 'Tidak Ditemukan',
                    'statusStunting' => 'Bumil',
                ];
            });

        $stuntingData = $baduta->merge($bumil);
        return Inertia::render('StuntingTPK', [
            'stuntingData' => $stuntingData,
        ]);
        

    }
}
