<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Baduta;
use App\Models\Bumil;
use App\Models\Pandugenre;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil total semua penduduk
        $totalPenduduk = Penduduk::count();

        // Hitung total stunting dari Baduta dan Bumil
        $badutaStunting = Baduta::where('stunting', 'Ya')->count();
        $bumilStunting = Bumil::where('stunting', 'Ya')->count();
        $totalStunting = $badutaStunting + $bumilStunting;

        // Hitung jumlah terapi Pandu Genre yang berasal dari Baduta stunting
        $badutaStuntingNIKs = Baduta::where('stunting', 'Ya')->pluck('penduduk_nik')->toArray();

        $jumlahTertangani = PanduGenre::whereIn('nik', $badutaStuntingNIKs)->count();

        // Persentase perkembangan = yang ditangani / total baduta stunting
        $totalPerkembangan = $badutaStunting > 0
            ? round(($jumlahTertangani / $badutaStunting) * 100, 1)
            : 0;

        return Inertia::render('Dashboard', [
            'totalPerKategori' => $totalPenduduk,
            'totalStunting' => $totalStunting,
            'totalPerkembangan' => $totalPerkembangan,
        ]);
    }
}

