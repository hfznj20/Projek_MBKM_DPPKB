<?php

namespace App\Http\Controllers;

use App\Models\Bumil;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use App\Models\TPK;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class BumilController extends Controller
{
    public function index()
    {
        $bumils = DB::table('bumil')
            ->join('penduduk', 'bumil.penduduk_nik', '=', 'penduduk.nik')
            ->select('bumil.id', 'bumil.stunting', 'penduduk.nik', 'penduduk.nama', 'penduduk.kecamatan', 'penduduk.kelurahan')
            ->get();
        return Inertia::render('Bumil/Index', [
            'bumils' => $bumils,
        ]);
    }

    public function create(Request $request)
    {
        $penduduks = Penduduk::all();
        return Inertia::render('Bumil/Create', [
            'penduduks' => $penduduks,
            'penduduk_nik' => $request->nik,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'penduduk_nik' => 'required|exists:penduduk,nik', // nik bumil
            'usia_kehamilan' => 'required|integer',
            'TUF' => 'required|integer',
            'jumlah_anak_kandung' => 'required|integer',
            'tgl_lahir_ank_terakhir' => 'required|date',
            'tinggi_badan' => 'required|integer',
            'berat_badan_sebelum_hamil' => 'required|integer',
            'berat_badan_saat_ini' => 'required|integer',
            'indeks_massa_tubuh' => 'required|numeric',
            'kadar_hemoglobin' => 'required|numeric',
            'LILA' => 'required|numeric',
            'menggunakan_alat_kontrasepsi' => 'nullable|string',
            'sumber_air_minum' => 'nullable|string',
            'fasilitas_BAB' => 'nullable|string',
            'meerokok_terpapar' => 'nullable|string',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'mendapatkan_tablet_tambah_darah' => 'nullable|string',
            'meminum_table_tambah_darah' => 'nullable|string',
            'penyuluhan_KIE' => 'nullable|string',
            'fasilitas_layanan_rujukan' => 'nullable|string',
            'fasilitas_bantuan_sosial' => 'nullable|string',
            'stunting' => 'required|string',
        ]);
 
        Bumil::create($request->all());

        return redirect()->route('penduduk.index')->with('success', 'Data Bumil berhasil disimpan');
    }

    public function show($id)
    {
        $bumil = Bumil::findOrFail($id);
        return view('bumil.show', compact('bumil'));
    }

    public function edit($id)
    {
        $bumil = Bumil::findOrFail($id);
        $penduduks = Penduduk::all();
        return view('bumil.edit', compact('bumil', 'penduduks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'usia_kehamilan' => 'required|integer',
            'TUF' => 'required|integer',
            'jumlah_anak_kandung' => 'required|integer',
            'tgl_lahir_ank_terakhir' => 'required|date',
            'tinggi_badan' => 'required|integer',
            'berat_badan_sebelum_hamil' => 'required|integer',
            'berat_badan_saat_ini' => 'required|integer',
            'indeks_massa_tubuh' => 'nullable|numeric',
            'kadar_hemoglobin' => 'nullable|numeric',
            'LILA' => 'nullable|numeric',
            'menggunakan_alat_kontrasepsi' => 'nullable|string',
            'meerokok_terpapar' => 'nullable|string',
            'sumber_air_minum' => 'nullable|string',
            'fasilitas_BAB' => 'nullable|string',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'mendapatkan_tablet_tambah_darah' => 'nullable|string',
            'meminum_table_tambah_darah' => 'nullable|string',
            'penyuluhan_KIE' => 'nullable|string',
            'fasilitas_layanan_rujukan' => 'nullable|string',
            'fasilitas_bantuan_sosial' => 'nullable|string',
        ]);

        $bumil = Bumil::findOrFail($id);
        $bumil->update($request->all());

        return redirect()->route('penduduk.index')->with('success', 'Data Bumil berhasil diperbarui');
    }

    public function destroy($id)
    {
        $bumil = Bumil::findOrFail($id);
        $bumil->delete();

        return redirect()->route('bumil.index')->with('success', 'Data Bumil berhasil dihapus');
    }
}