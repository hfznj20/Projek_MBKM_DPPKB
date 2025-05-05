<?php

namespace App\Http\Controllers;

use App\Models\Bumil;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use App\Models\TPK;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    public function show($nik)
    {
        $bumil = Bumil::with('penduduk')->where('penduduk_nik', $nik)->firstOrFail();

        $penduduk = $bumil->penduduk;
        $usia = Carbon::parse($penduduk->tanggal_lahir)->age;

        return Inertia::render('Bumil/Show', [
            'bumil' => [
                'nama' => $penduduk->nama,
                'nik' => $penduduk->nik,
                'tempat_lahir' => $penduduk->tempat_lahir,
                'tanggal_lahir' => $penduduk->tanggal_lahir,
                'jenis_kelamin' => $penduduk->jenis_kelamin,
                'alamat' => $penduduk->alamat,
                'no_hp' => $penduduk->no_hp,
                'usia' => $usia,

                'usia_kehamilan' => $bumil->usia_kehamilan,
                'jumlah_anak_kandung' => $bumil->jumlah_anak_kandung,
                'tgl_lahir_ank_terakhir' => $bumil->tgl_lahir_ank_terakhir,
                'berat_badan_saat_ini' => $bumil->berat_badan_saat_ini,
                'tinggi_badan' => $bumil->tinggi_badan,
                'indeks_massa_tubuh' => $bumil->indeks_massa_tubuh,
                'LILA' => $bumil->LILA,
                'kadar_hemoglobin' => $bumil->kadar_hemoglobin,
                'menggunakan_alat_kontrasepsi' => $bumil->menggunakan_alat_kontrasepsi,
                'sumber_air_minum' => $bumil->sumber_air_minum,
                'fasilitas_BAB' => $bumil->fasilitas_BAB,
                'meerokok_terpapar' => $bumil->meerokok_terpapar,
            ],
        ]);
    }

    public function edit($nik)
    {
        $bumil = Bumil::findOrFail($nik);
        $penduduks = Penduduk::all();
        return view('bumil.edit', compact('bumil', 'penduduks'));
    }

    public function update(Request $request, $nik)
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

        $bumil = Bumil::findOrFail($nik);
        $bumil->update($request->all());

        return redirect()->route('penduduk.index')->with('success', 'Data Bumil berhasil diperbarui');
    }

    public function destroy($nik)
    {
        $bumil = Bumil::where('penduduk_nik', $nik)->firstOrFail();
        $bumil->delete();

        return redirect()->route('bumil.index')->with('success', 'Data bumil berhasil dihapus.');
    }
}