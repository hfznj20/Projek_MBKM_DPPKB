<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Baduta;
use App\Models\Bumil;
use App\Models\Pandugenre;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

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
        
        //persentase badutas stunting
        $total = DB::table('baduta')->count();
        $stunting = DB::table('baduta')->where('stunting', 'Ya')->count();

        $persentasebaduta = $total > 0 ? round(($stunting / $total) * 100, 2) : 0;
        
        //persentase bumils stunting
        $total = DB::table('bumil')->count();
        $stunting = DB::table('bumil')->where('stunting', 'Ya')->count();

        $persentasebumil = $total > 0 ? round(($stunting / $total) * 100, 2) : 0;


        // Grafik Bar Stunting: kategori vs status stunting
        // $baduta = DB::table('baduta')
        //     ->select(DB::raw("'Baduta' as kategori"), 'stunting', DB::raw('count(*) as total'))
        //     ->groupBy('stunting');

        // $bumil = DB::table('bumil')
        //     ->select(DB::raw("'Bumil' as kategori"), 'stunting', DB::raw('count(*) as total'))
        //     ->groupBy('stunting');

        // $grafikStunting = $baduta->unionAll($bumil)->get();


        return Inertia::render('Dashboard', [
            'totalPerKategori' => $totalPenduduk,
            'totalStunting' => $totalStunting,
            'totalPerkembangan' => $totalPerkembangan,
            'persentasebaduta' => $persentasebaduta,
            'persentasebumil' => $persentasebumil,
            // 'grafikStunting' => $grafikStunting,
        ]);
    }

    public function grafikStunting()
    {
        // Gabungkan data dari tabel baduta dan bumil
        $baduta = DB::table('baduta')
            ->select(DB::raw("'Baduta' as kategori"), 'stunting', DB::raw('COUNT(*) as total'))
            ->groupBy('stunting');

        $bumil = DB::table('bumil')
            ->select(DB::raw("'Bumil' as kategori"), 'stunting', DB::raw('COUNT(*) as total'))
            ->groupBy('stunting');

        // Union kedua tabel
        $data = $baduta->unionAll($bumil)->get();

        return response()->json($data);
    }

}

