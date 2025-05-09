<?php

namespace App\Http\Controllers;

use App\Models\KunjunganBumil;
use Illuminate\Http\Request;

class KunjunganBumilController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'penduduk_nik' => 'required|exists:penduduk,nik',
            'tanggal' => 'required|date',
            'usia_kehamilan' => 'required|integer',
            'TUF' => 'required|integer',
            'tinggi_badan' => 'required|numeric',
            'berat_badan_sebelum_hamil' => 'required|integer',
            'berat_badan_saat_ini' => 'required|integer',
            'indeks_massa_tubuh' => 'required|numeric',
            'kadar_hemoglobin' => 'required|numeric',
            'LILA' => 'required|numeric',
            'menggunakan_alat_kontrasepsi' => 'nullable|string',
            'sumber_air_minum' => 'nullable|string',
            'fasilitas_BAB' => 'nullable|string',
            'meerokok_terpapar' => 'nullable|string',
            'mendapatkan_tablet_tambah_darah' => 'nullable|string',
            'meminum_table_tambah_darah' => 'nullable|string',
            'penyuluhan_KIE' => 'nullable|string',
            'fasilitas_layanan_rujukan' => 'nullable|string',
            'fasilitas_bantuan_sosial' => 'nullable|string',
        ]);

        $kunjungan = new KunjunganBumil();
        $kunjungan->penduduk_nik = $request->penduduk_nik;
        $kunjungan->tanggal_kunjungan = $request->tanggal;
        $kunjungan->usia_kehamilan = $request->usia_kehamilan;
        $kunjungan->TUF = $request->TUF;
        $kunjungan->tinggi_badan = $request->tinggi_badan;
        $kunjungan->berat_badan_sebelum_hamil = $request->berat_badan_sebelum_hamil;
        $kunjungan->berat_badan_saat_ini = $request->berat_badan_saat_ini;
        $kunjungan->indeks_massa_tubuh = $request->indeks_massa_tubuh;
        $kunjungan->kadar_hemoglobin = $request->kadar_hemoglobin;
        $kunjungan->LILA = $request->LILA;
        $kunjungan->menggunakan_alat_kontrasepsi = $request->menggunakan_alat_kontrasepsi;
        $kunjungan->sumber_air_minum = $request->sumber_air_minum;
        $kunjungan->fasilitas_BAB = $request->fasilitas_BAB;
        $kunjungan->meerokok_terpapar = $request->meerokok_terpapar;
        $kunjungan->mendapatkan_tablet_tambah_darah = $request->mendapatkan_tablet_tambah_darah;
        $kunjungan->meminum_table_tambah_darah = $request->meminum_table_tambah_darah;
        $kunjungan->penyuluhan_KIE = $request->penyuluhan_KIE;
        $kunjungan->fasilitas_layanan_rujukan = $request->fasilitas_layanan_rujukan;
        $kunjungan->fasilitas_bantuan_sosial = $request->fasilitas_bantuan_sosial;
        $kunjungan->save();

        return redirect()->route('bumil.show', ['nik' => $request->penduduk_nik])
                         ->with('success', 'Data kunjungan bumil berhasil disimpan.');
    }
}
