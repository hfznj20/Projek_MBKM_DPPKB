<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penduduk;
use App\Models\Baduta;
use App\Models\Bumil;
use Illuminate\Support\Carbon;

class MapsebaranController extends Controller
{
    public function show($nama)
    {
        try {
            // Ambil jumlah penduduk kategori 'baduta' berdasarkan kecamatan
            $jumlahBaduta = Penduduk::where('kecamatan', $nama)
                ->where('kategori', 'BADUTA')
                ->count();

            // Ambil jumlah penduduk kategori 'catin' berdasarkan kecamatan
            $jumlahCatin = Penduduk::where('kecamatan', $nama)
                ->where('kategori', 'CATIN')
                ->count();

            // Ambil jumlah penduduk kategori 'bumil' berdasarkan kecamatan
            $jumlahBumil = Penduduk::where('kecamatan', $nama)
                ->where('kategori', 'BUMIL')
                ->count();

            // Ambil jumlah penduduk kategori 'pasca persalinan' berdasarkan kecamatan
            $jumlahPascaPersalinan = Penduduk::where('kecamatan', $nama)
                ->where('kategori', 'Pasca Persalinan')
                ->count();

            return response()->json([
                'kecamatan' => $nama,
                'jumlah_baduta' => $jumlahBaduta,
                'jumlah_catin' => $jumlahCatin,
                'jumlah_bumil' => $jumlahBumil,
                'jumlah_pasca_persalinan' => $jumlahPascaPersalinan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

public function getSebaranUjung()
{
    $badutaCount = Penduduk::where('kategori', 'BADUTA')
        ->where('kecamatan', 'Ujung')
        ->count();

    $badutaLaki = Penduduk::where('kategori', 'BADUTA')
        ->where('kecamatan', 'Ujung')
        ->where('jenis_kelamin', 'Laki-laki')
        ->count();

    $badutaPerempuan = Penduduk::where('kategori', 'BADUTA')
        ->where('kecamatan', 'Ujung')
        ->where('jenis_kelamin', 'Perempuan')
        ->count();

    $catinCount = Penduduk::where('kategori', 'CATIN')
        ->where('kecamatan', 'Ujung')
        ->count();

    $bumilCount = Penduduk::where('kategori', 'BUMIL')
        ->where('kecamatan', 'Ujung')
        ->count();

    $pascaPersalinanCount = Penduduk::where('kategori', 'PASCA PERSALINAN')
        ->where('kecamatan', 'Ujung')
        ->count();

    return response()->json([
        'baduta' => $badutaCount,
        'baduta_laki' => $badutaLaki,
        'baduta_perempuan' => $badutaPerempuan,
        'catin' => $catinCount,
        'bumil' => $bumilCount,
        'pasca_persalinan' => $pascaPersalinanCount,
    ]);
}


public function getUmurStatistik()
{
    // Rentang umur dalam bulan
    $umurGroups = [
        '0-5' => [0, 5],
        '6-11' => [6, 11],
        '12-23' => [12, 23],
        '24-59' => [24, 59],
        '> 59' => [60, 200],
    ];

    $result = [];

    foreach ($umurGroups as $label => [$min, $max]) {
        // Menghitung jumlah Baduta berdasarkan umur dalam bulan
        $result[$label] = Penduduk::where('kategori', 'BADUTA')
            ->where('kecamatan', 'Ujung')
            ->whereNotNull('tanggal_lahir')
            ->whereBetween(
                DB::raw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE())'),
                [$min, $max]
            )
            ->count();
    }

    return response()->json($result);  // Mengembalikan data dalam format JSON
}
public function getStuntingPerKelurahan()
{
    try {
        $data = DB::table('baduta')
            ->join('penduduk', 'baduta.penduduk_nik', '=', 'penduduk.nik')
            ->select(
                'penduduk.kelurahan',
                DB::raw("COUNT(CASE WHEN baduta.stunting = 'Ya' THEN 1 END) as jumlah_stunting"),
                DB::raw("COUNT(*) as total")
            )
            ->groupBy('penduduk.kelurahan')
            ->get()
            ->map(function ($item) {
                $item->proporsi = $item->total > 0
                    ? round(($item->jumlah_stunting / $item->total) * 100, 2) . '%'
                    : '0%';
                return $item;
            });

        return response()->json($data);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function getTTDStatistik()
{
    // Data dari tabel bumil
    $bumilTotal = DB::table('bumil')
        ->join('penduduk', 'bumil.penduduk_nik', '=', 'penduduk.nik')
        ->where('penduduk.kecamatan', 'Ujung')
        ->count();

    $bumilYa = DB::table('bumil')
        ->join('penduduk', 'bumil.penduduk_nik', '=', 'penduduk.nik')
        ->where('penduduk.kecamatan', 'Ujung')
        ->where('bumil.mendapatkan_tablet_tambah_darah', 'Ya')
        ->count();

    // Data dari tabel catin
    $catinTotal = DB::table('catin')
        ->join('penduduk', 'catin.nik_catin1', '=', 'penduduk.nik')
        ->where('penduduk.kecamatan', 'Ujung')
        ->count();

    $catinYa = DB::table('catin')
        ->join('penduduk', 'catin.nik_catin1', '=', 'penduduk.nik')
        ->where('penduduk.kecamatan', 'Ujung')
        ->where('catin.mendapatkan_tablet_tambah_darah', 'Ya')
        ->count();

    // Gabungan total dan jumlah "Ya"
    $total = $bumilTotal + $catinTotal;
    $jumlahYa = $bumilYa + $catinYa;

    return response()->json([
        'total' => $total,
        'jumlah_ya' => $jumlahYa
    ]);
}
public function getIbuAnakLebihDari2()
{
    // Data dari tabel bumil
    $bumilData = DB::table('bumil')
        ->join('penduduk', 'bumil.penduduk_nik', '=', 'penduduk.nik')
        ->where('penduduk.kecamatan', 'Ujung')
        ->select('bumil.jumlah_anak_kandung')
        ->get();

    // Data dari tabel baduta
    $badutaData = DB::table('baduta')
        ->join('penduduk', 'baduta.penduduk_nik', '=', 'penduduk.nik')
        ->where('penduduk.kecamatan', 'Ujung')
        ->select('baduta.jumlah_anak_kandung')
        ->get();

    // Gabungkan dan hitung
    $allData = $bumilData->merge($badutaData);

    $totalIbu = $allData->count();
    $lebihDari2 = $allData->filter(fn($item) => (int) $item->jumlah_anak_kandung > 2)->count();

    return response()->json([
        'total' => $totalIbu,
        'lebih_dari_2' => $lebihDari2,
    ]);
}
public function getAksesAirMinumLayak()
{
    // Daftar sumber air minum yang dianggap layak
    $layak = [
        "Air kemasan",
        'Isi ulang',
        "Ledeng/PAM",
        "Sumur bor/Pompa",
        "Sumur terlindungi"
    ];

    // Ambil data dari tabel catin
    $catinData = DB::table('catin')
        ->join('penduduk', 'catin.nik_catin1', '=', 'penduduk.nik')
        ->where('penduduk.kecamatan', 'Ujung')
        ->select('catin.sumber_air_minum')
        ->get();
    $bumilData = DB::table('bumil')
        ->join('penduduk', 'bumil.penduduk_nik', '=', 'penduduk.nik')
        ->where('penduduk.kecamatan', 'Ujung')
        ->select('bumil.sumber_air_minum')
        ->get();

    // Ambil data dari tabel baduta
    $badutaData = DB::table('baduta')
        ->join('penduduk', 'penduduk_nik', '=', 'penduduk.nik')
        ->where('penduduk.kecamatan', 'Ujung')
        ->select('baduta.sumber_air_minum')
        ->get();

    // Gabungkan data
    $allData = $catinData->merge($badutaData)->merge($bumilData);

    $total = $allData->count();
    $layakCount = $allData->filter(fn($item) =>
        in_array($item->sumber_air_minum, $layak)
    )->count();

    return response()->json([
        'total' => $total,
        'layak' => $layakCount,
        'tidak_layak' => $total - $layakCount,
    ]);
}

}