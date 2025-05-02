<?php

namespace App\Http\Controllers;

use App\Models\Catin;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class CatinController extends Controller
{
    public function __construct()
    {
        // Menambahkan middleware untuk memastikan hanya admin atau yang berwenang yang bisa mengakses
        // $this->middleware('auth');
    }

    // Menampilkan semua data catin
    public function index()
    {
        $catins = Catin::all();
        return view('catin.index', compact('catins'));
    }

    // Menampilkan form pendaftaran catin berdasarkan penduduk yang dipilih
    public function create($penduduk_nik)
    {
        $penduduk = Penduduk::findOrFail($penduduk_nik);
        $penduduks = Penduduk::all();
        return view('catin.create', compact('penduduks', 'penduduk'));
    }

    // Menyimpan data catin
    public function store(Request $request)
    {
        $this->validateCatin($request);

        $penduduk = Penduduk::findOrFail($request->penduduk_nik);

        // Jika data penduduk ditemukan, simpan data catin
        Catin::create([
            'nik_pria' => $request->nik_pria,
            'nik_wanita' => $request->nik_wanita,
            'tanggal_pernikahan' => $request->tanggal_pernikahan,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'indeks_massa_tubuh' => $request->indeks_massa_tubuh,
            'kadar_hemoglobin' => $request->kadar_hemoglobin,
            'LILA' => $request->LILA,
            'menggunakan_alat_kontrasepsi' => $request->menggunakan_alat_kontrasepsi,
            'catin_wanita_meerokok_terpapar' => $request->catin_wanita_meerokok_terpapar,
            'catin_pria_meerokok_terpapar' => $request->catin_pria_meerokok_terpapar,
            'sumber_air_minum' => $request->sumber_air_minum,
            'fasilitas_BAB' => $request->fasilitas_BAB,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'mendapatkan_tablet_tambah_darah' => $request->mendapatkan_tablet_tambah_darah,
            'meminum_table_tambah_darah' => $request->meminum_table_tambah_darah,
            'penyuluhan_KIE' => $request->penyuluhan_KIE,
            'fasilitas_layanan_rujukan' => $request->fasilitas_layanan_rujukan,
            'fasilitas_bantuan_sosial' => $request->fasilitas_bantuan_sosial,
        ]);

        return redirect()->route('penduduk.index')->with('success', 'Data Catin berhasil disimpan');
    }

    // Menampilkan detail catin berdasarkan id
    public function show($id)
    {
        $catin = Catin::findOrFail($id);
        return view('catin.show', compact('catin'));
    }

    // Menampilkan form edit data catin
    public function edit($id)
    {
        $catin = Catin::findOrFail($id);
        $penduduks = Penduduk::all();
        return view('catin.edit', compact('catin', 'penduduks'));
    }

    // Mengupdate data catin
    public function update(Request $request, $id)
    {
        $this->validateCatin($request);

        $catin = Catin::findOrFail($id);
        $catin->update([
            'nik_pria' => $request->nik_pria,
            'nik_wanita' => $request->nik_wanita,
            'tanggal_pernikahan' => $request->tanggal_pernikahan,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'indeks_massa_tubuh' => $request->indeks_massa_tubuh,
            'kadar_hemoglobin' => $request->kadar_hemoglobin,
            'LILA' => $request->LILA,
            'menggunakan_alat_kontrasepsi' => $request->menggunakan_alat_kontrasepsi,
            'catin_wanita_meerokok_terpapar' => $request->catin_wanita_meerokok_terpapar,
            'catin_pria_meerokok_terpapar' => $request->catin_pria_meerokok_terpapar,
            'sumber_air_minum' => $request->sumber_air_minum,
            'fasilitas_BAB' => $request->fasilitas_BAB,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'mendapatkan_tablet_tambah_darah' => $request->mendapatkan_tablet_tambah_darah,
            'meminum_table_tambah_darah' => $request->meminum_table_tambah_darah,
            'penyuluhan_KIE' => $request->penyuluhan_KIE,
            'fasilitas_layanan_rujukan' => $request->fasilitas_layanan_rujukan,
            'fasilitas_bantuan_sosial' => $request->fasilitas_bantuan_sosial,
        ]);

        return redirect()->route('catin.index')->with('success', 'Data Catin berhasil diperbarui');
    }

    // Menghapus data catin
    public function destroy($id)
    {
        $catin = Catin::findOrFail($id);
        $catin->delete();

        return redirect()->route('catin.index')->with('success', 'Data Catin berhasil dihapus');
    }

    // Fungsi validasi untuk form input data catin
    protected function validateCatin(Request $request)
    {
        $request->validate([
            'nik_pria' => 'required|exists:penduduk,nik',
            'nik_wanita' => 'required|exists:penduduk,nik',
            'tanggal_pernikahan' => 'required|date',
            'tinggi_badan' => 'required|integer|min:0',
            'berat_badan' => 'required|integer|min:0',
            'indeks_massa_tubuh' => 'required|integer|min:0',
            'kadar_hemoglobin' => 'required|integer|min:0',
            'LILA' => 'required|integer|min:0',
            'menggunakan_alat_kontrasepsi' => 'nullable|string',
            'catin_wanita_meerokok_terpapar' => 'nullable|string',
            'catin_pria_meerokok_terpapar' => 'nullable|string',
            'sumber_air_minum' => 'nullable|string',
            'fasilitas_BAB' => 'nullable|string',
            'longitude' => 'required|numeric|between:-180,180',
            'latitude' => 'required|numeric|between:-90,90',
            'mendapatkan_tablet_tambah_darah' => 'nullable|string',
            'meminum_table_tambah_darah' => 'nullable|string',
            'penyuluhan_KIE' => 'nullable|string',
            'fasilitas_layanan_rujukan' => 'nullable|string',
            'fasilitas_bantuan_sosial' => 'nullable|string',
        ]);
    }
}
