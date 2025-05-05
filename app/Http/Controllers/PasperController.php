<?php

namespace App\Http\Controllers;

use App\Models\Pasper;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PasperController extends Controller
{
    public function index()
    {
        $pasca_persalinan = DB::table('pasca_persalinan')
            ->join('penduduk', 'pasca_persalinan.penduduk_nik', '=', 'penduduk.nik')
            ->select(
                'pasca_persalinan.id',
                'pasca_persalinan.tanggal_persalinan',
                'penduduk.nik',
                'penduduk.nama',
                'penduduk.kecamatan',
                'penduduk.kelurahan'
            )
            ->orderBy('pasca_persalinan.created_at', 'desc')
            ->get();
    
        return Inertia::render('Pasper/Index', [
            'pasper' => $pasca_persalinan,
        ]);
    }
    

    public function create(Request $request)
    {
        // Ambil semua penduduk untuk form input
        $penduduks = Penduduk::all();
        // ambil penduduk_nik dari URL jika ada
        $penduduk_nik = $request->penduduk_nik;

        return Inertia::render('Pasper/Create', compact('penduduks', 'penduduk_nik'));
    }

    public function store(Request $request)
    {
        // Valnikasi input
        $request->validate([
            'penduduk_nik' => 'required|exists:penduduk,nik', // nik penduduk
            'tanggal_persalinan' => 'required|date',
            'tempat_persalinan' => 'required|string',
            'penolong_persalinan' => 'required|string',
            'cara_persalinan' => 'required|string',
            'keadaan_bayi' => 'required|string',
            'menggunakan_alat_kontrasepsi' => 'nullable|string',
            'meerokok_terpapar' => 'nullable|string',
            'sumber_air_minum' => 'nullable|string',
            'fasilitas_BAB' => 'nullable|string',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'mendapatkan_tablet_tambah_darah' => 'nullable|string',
            'meminum_table_tambah_darah' => 'nullable|string',
            'penyuluhan_KIE' => 'nullable|string',
            'fasilitas_layanan_rujukan' => 'nullable|string',
        ]);

        // Ambil data penduduk berdasarkan penduduk_
        $penduduk = Penduduk::find($request->penduduk_nik);


            // Menyimpan data Pasper ke database
            Pasper::create([
                'penduduk_nik' => $request->penduduk_nik,
                'tanggal_persalinan' => $request->tanggal_persalinan,
                'tempat_persalinan' => $request->tempat_persalinan,
                'penolong_persalinan' => $request->penolong_persalinan,
                'cara_persalinan' => $request->cara_persalinan,
                'keadaan_bayi' => $request->keadaan_bayi,
                'menggunakan_alat_kontrasepsi' => $request->menggunakan_alat_kontrasepsi,
                'meerokok_terpapar' => $request->meerokok_terpapar,
                'sumber_air_minum' => $request->sumber_air_minum,
                'fasilitas_BAB' => $request->fasilitas_BAB,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'mendapatkan_tablet_tambah_darah' => $request->mendapatkan_tablet_tambah_darah,
                'meminum_table_tambah_darah' => $request->meminum_table_tambah_darah,
                'penyuluhan_KIE' => $request->penyuluhan_KIE,
                'fasilitas_layanan_rujukan' => $request->fasilitas_layanan_rujukan,
            ]);


        // Redirect ke halaman Pasper
        return redirect()->route('penduduk.index')->with('success', 'Data Pasper berhasil disimpan');
    }

    public function show($nik)
    {
        $pasper = Pasper::with('penduduk')->where('penduduk_nik', $nik)->firstOrFail();
    
        $penduduk = $pasper->penduduk;
        $usia = Carbon::parse($penduduk->tanggal_lahir)->age;
    
        return Inertia::render('Pasper/Show', [
            'pasper' => [
                'nama' => $penduduk->nama,
                'nik' => $penduduk->nik,
                'tempat_lahir' => $penduduk->tempat_lahir,
                'tanggal_lahir' => $penduduk->tanggal_lahir,
                'jenis_kelamin' => $penduduk->jenis_kelamin,
                'alamat' => $penduduk->alamat,
                'no_hp' => $penduduk->no_hp,
                'usia' => $usia,
    
                'tanggal_persalinan' => $pasper->tanggal_persalinan,
                'tempat_persalinan' => $pasper->tempat_persalinan,
                'penolong_persalinan' => $pasper->penolong_persalinan,
                'cara_persalinan' => $pasper->cara_persalinan,
                'keadaan_bayi' => $pasper->keadaan_bayi,
                'menggunakan_alat_kontrasepsi' => $pasper->menggunakan_alat_kontrasepsi,
                'meerokok_terpapar' => $pasper->meerokok_terpapar,
                'sumber_air_minum' => $pasper->sumber_air_minum,
                'fasilitas_BAB' => $pasper->fasilitas_BAB,
            ],
        ]);
    }

    public function edit($nik)
    {
        $pasper = Pasper::findOrFail($nik);
        return Inertia::render('Pasper/Edit', [
            'pasper' => $pasper,
        ]);
    }

    public function update(Request $request, $nik)
    {
        // Valnikasi input
        $request->valnikate([
            'penduduk_nik' => 'required|exists:penduduk,nik', // nik penduduk
            'tanggal_persalinan' => 'required|date',
            'tempat_persalinan' => 'required|string',
            'penolong_persalinan' => 'required|string',
            'cara_persalinan' => 'required|string',
            'keadaan_bayi' => 'required|string',
            'menggunakan_alat_kontrasepsi' => 'nullable|string',
            'meerokok_terpapar' => 'nullable|string',
            'sumber_air_minum' => 'nullable|string',
            'fasilitas_BAB' => 'nullable|string',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'mendapatkan_tablet_tambah_darah' => 'nullable|string',
            'meminum_table_tambah_darah' => 'nullable|string',
            'penyuluhan_KIE' => 'nullable|string',
            'fasilitas_layanan_rujukan' => 'nullable|string',
        ]);

        // Cari data Pasper yang akan diperbarui
        $pasper = Pasper::findOrFail($nik);
        $pasper->update([
            'penduduk_nik' => $request->penduduk_nik,
            'tanggal_persalinan' => $request->tanggal_persalinan,
            'tempat_persalinan' => $request->tempat_persalinan,
            'penolong_persalinan' => $request->penolong_persalinan,
            'cara_persalinan' => $request->cara_persalinan,
            'keadaan_bayi' => $request->keadaan_bayi,
            'menggunakan_alat_kontrasepsi' => $request->menggunakan_alat_kontrasepsi,
            'meerokok_terpapar' => $request->meerokok_terpapar,
            'sumber_air_minum' => $request->sumber_air_minum,
            'fasilitas_BAB' => $request->fasilitas_BAB,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'mendapatkan_tablet_tambah_darah' => $request->mendapatkan_tablet_tambah_darah,
            'meminum_table_tambah_darah' => $request->meminum_table_tambah_darah,
            'penyuluhan_KIE' => $request->penyuluhan_KIE,
            'fasilitas_layanan_rujukan' => $request->fasilitas_layanan_rujukan,
        ]);

        return redirect()->route('pasper.index')->with('success', 'Data Pasper berhasil diperbarui');
    }

    public function destroy($nik)
    {
        $pasper = Pasper::where('penduduk_nik', $nik)->firstOrFail();
        $pasper->delete();

        return redirect()->route('pasper.index')->with('success', 'Data pasper berhasil dihapus.');
    }
}
