<?php

namespace App\Http\Controllers;

use App\Models\Pasper;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


class PasperController extends Controller
{
    public function index()
    {
        // Mengambil data dari pasca_persalinan dan penduduk
        $pasca_persalinan = DB::table('pasca_persalinan')
            ->join('penduduk', 'pasca_persalinan.penduduk_id', '=', 'penduduk.id')
            ->select('pasca_persalinan.id', 'pasca_persalinan.tanggal_persalinan', 'penduduk.nik', 'penduduk.nama')
            ->get();


        return Inertia::render('Pasper/Index', [
            'pasper' => $pasca_persalinan,
        ]);
    }

    public function create(Request $request)
    {
        // Ambil semua penduduk untuk form input
        $penduduks = Penduduk::all();
        // ambil penduduk_id dari URL jika ada
        $penduduk_id = $request->penduduk_id;

        return Inertia::render('Pasper/Create', compact('penduduks', 'penduduk_id'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id', // ID penduduk
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

        // Ambil data penduduk berdasarkan penduduk_id
        $penduduk = Penduduk::find($request->penduduk_id);


            // Menyimpan data Pasper ke database
            Pasper::create([
                'penduduk_id' => $request->penduduk_id,
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
        return redirect()->route('Pasper/Index')->with('success', 'Data Pasper berhasil disimpan');
    }

    public function show($id)
    {
        $pasper = Pasper::findOrFail($id);
        return Inertia::render('Pasper/Show', [
            'pasper' => $pasper,
        ]);
    }

    public function edit($id)
    {
        $pasper = Pasper::findOrFail($id);
        return Inertia::render('Pasper/Edit', [
            'pasper' => $pasper,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id', // ID penduduk
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
        $pasper = Pasper::findOrFail($id);
        $pasper->update([
            'penduduk_id' => $request->penduduk_id,
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

    public function destroy($id)
    {
        // Cari dan hapus data Pasper
        $pasper = Pasper::findOrFail($id);
        $pasper->delete();

        return redirect()->route('pasper.index')->with('success', 'Data Pasper berhasil dihapus');
    }
}
