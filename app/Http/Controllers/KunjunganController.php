<?php

namespace App\Http\Controllers;

use App\Models\Baduta;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'penduduk_nik' => 'required|exists:penduduk,nik',
            'tanggal_kunjungan' => 'required|date',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
            'menggunakan_alat_kontrasepsi' => 'nullable|string',
            'sumber_air_minum' => 'nullable|string',
            'asi_eksklusif' => 'nullable|string',
            'imunisasi_hepatitis_B' => 'nullable|string',
            'merokok_terpapar' => 'nullable|string',
            'mengisi_KKA' => 'nullable|string',
            'kehadiran_posyandu' => 'nullable|string',
            'penyuluhan_KIE' => 'nullable|string',
            'fasilitas_bantuan_sosial' => 'nullable|string',
        ]);
        Kunjungan::create([
        'penduduk_nik' => $request->penduduk_nik,
        'tanggal_kunjungan' => $request->tanggal_kunjungan,
        'berat_badan' => $request->berat_badan,
        'tinggi_badan' => $request->tinggi_badan,
        'menggunakan_alat_kontrasepsi' => $request->menggunakan_alat_kontrasepsi,
        'sumber_air_minum' => $request->sumber_air_minum,
        'asi_eksklusif' => $request->asi_eksklusif,
        'imunisasi_hepatitis_B' => $request->imunisasi_hepatitis_B,
        'merokok_terpapar' => $request->merokok_terpapar,
        'mengisi_KKA' => $request->mengisi_KKA,
        'kehadiran_posyandu' => $request->kehadiran_posyandu,
        'penyuluhan_KIE' => $request->penyuluhan_KIE,
        'fasilitas_bantuan_sosial' => $request->fasilitas_bantuan_sosial,
    ]);


        // Simpan data kunjungan
        // $kunjungan = new Kunjungan();
        // $kunjungan->penduduk_nik = $request->penduduk_nik;
        // $kunjungan->tanggal_kunjungan = $request->tanggal;
        // $kunjungan->berat_badan = $request->berat_badan;
        // $kunjungan->tinggi_badan = $request->tinggi_badan;
        // $kunjungan->menggunakan_alat_kontrasepsi = $request->menggunakan_alat_kontrasepsi;
        // $kunjungan->sumber_air_minum = $request->sumber_air_minum;
        // $kunjungan->asi_eksklusif = $request->asi_eksklusif;
        // $kunjungan->imunisasi_hepatitis_B = $request->imunisasi_hepatitis_B;
        // $kunjungan->merokok_terpapar = $request->merokok_terpapar;
        // $kunjungan->mengisi_KKA = $request->mengisi_KKA;
        // $kunjungan->kehadiran_posyandu = $request->kehadiran_posyandu;
        // $kunjungan->penyuluhan_KIE = $request->penyuluhan_KIE;
        // $kunjungan->fasilitas_bantuan_sosial = $request->fasilitas_bantuan_sosial;
        // $kunjungan->save();

        // return redirect()->route('baduta.show', ['nik' => $request->penduduk_nik])
                        //  ->with('success', 'Data kunjungan berhasil disimpan.');
    
        return back()->with('success', 'Data kunjungan berhasil disimpan.');
    }
    public function showKunjungan($nik, $id)
{
    $kunjungan = Kunjungan::where('penduduk_nik', $nik)->where('id', $id)->firstOrFail();
    $baduta = Baduta::where('penduduk_nik', $nik)->first(); // Ambil data baduta

    return Inertia::render('Baduta/TambahKunjunganshow', [
        'kunjungan' => $kunjungan,
        'baduta' => $baduta // Kirim data baduta juga
    ]);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
