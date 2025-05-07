<?php

namespace App\Http\Controllers;

use App\Models\Catin;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use App\Models\TPK;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class CatinController extends Controller
{
    public function index()
    {
        $catins = Catin::orderBy('created_at', 'desc')->get();

        return Inertia::render('Catin/Index', [
            'catins' => $catins,
        ]);
    }
    
    public function create(Request $request)
    {
        $penduduks = Penduduk::all();

        $catin = null;
        if ($request->nik) {
            $catin = Penduduk::where('nik', $request->nik)->first();
        }
        return Inertia::render('Catin/Create', [
            'penduduks' => $penduduks,
            'penduduk_nik' => $request->nik,
            'catin' => $catin,
        ]);
    }

    
    public function store(Request $request)
    {
        Log::info($request->all());

        // Validasi input
        $request->validate([
            'nik_catin1' => 'required|exists:penduduk,nik',
            'nik_catin2' => 'required|exists:penduduk,nik',
            'tanggal_pernikahan' => 'required|date',
            'tinggi_badan' => 'required|integer',
            'berat_badan' => 'required|integer',
            'indeks_massa_tubuh' => 'required|integer',
            'kadar_hemoglobin' => 'required|integer',
            'LILA' => 'required|integer',
            'menggunakan_alat_kontrasepsi' => 'nullable|string',
            'sumber_air_minum' => 'nullable|string',
            'fasilitas_BAB' => 'nullable|string',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'fasilitas_bantuan_sosial' => 'nullable|string',
        ]);

        // Cek apakah pasangan kedua sudah ada
        $pasangan_kedua = Penduduk::where('nik', $request->nik_catin2)->first();

        if (!$pasangan_kedua) {
            $pasangan_kedua = Penduduk::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'RT' => $request->RT,
                'RW' => $request->RW,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);
        }

        Catin::create([
            'nik_catin1' => $request->nik_catin1,
            'nik_catin2' => $request->nik_catin2,
            'tanggal_pernikahan' => $request->tanggal_pernikahan,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'indeks_massa_tubuh' => $request->indeks_massa_tubuh,
            'kadar_hemoglobin' => $request->kadar_hemoglobin,
            'LILA' => $request->LILA,
            'menggunakan_alat_kontrasepsi' => $request->menggunakan_alat_kontrasepsi,
            'sumber_air_minum' => $request->sumber_air_minum,
            'fasilitas_BAB' => $request->fasilitas_BAB,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'fasilitas_bantuan_sosial' => $request->fasilitas_bantuan_sosial,
        ]);

        return redirect()->route('penduduk.index')->with('success', 'Data Catin berhasil disimpan');
    }

    public function storePasanganBaru(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16|unique:penduduk,nik',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|in:Ujung,Bacukiki,Bacukiki Barat,Soreang',
            'RT' => 'required|string|max:3',
            'RW' => 'required|string|max:3',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:16',
        ]);

        $pasangan = Penduduk::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'RT' => $request->RT,
            'RW' => $request->RW,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return response()->json([
            'status' => 'success',
            'nik' => $pasangan->nik,
            'nama' => $pasangan->nama,
        ]);
    }
}
