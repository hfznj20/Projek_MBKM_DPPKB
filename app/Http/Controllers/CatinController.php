<?php

namespace App\Http\Controllers;

use App\Models\Catin;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use App\Models\TPK;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CatinController extends Controller
{
    public function index()
    {
        $catins = Catin::with(['catin1', 'catin2'])->get()->map(function ($catin) {
            $pria = null;
            $wanita = null;
    
            if ($catin->catin1 && $catin->catin1->jenis_kelamin === 'Laki-laki') {
                $pria = $catin->catin1;
            } elseif ($catin->catin1 && $catin->catin1->jenis_kelamin === 'Perempuan') {
                $wanita = $catin->catin1;
            }
    
            if ($catin->catin2 && $catin->catin2->jenis_kelamin === 'Laki-laki') {
                $pria = $catin->catin2;
            } elseif ($catin->catin2 && $catin->catin2->jenis_kelamin === 'Perempuan') {
                $wanita = $catin->catin2;
            }
    
            return [
                'id' => $catin->id,
                'nik' => $catin->nik_catin1,
                'nama' => $wanita?->nama ?? '-',
                'nama_pasangan' => $pria?->nama ?? '-',
                'tanggal_rencana_pernikahan' => $catin->tanggal_pernikahan,
            ];
        });
    
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

    public function show($nik)
    {
        $catin = Catin::with(['catin1', 'catin2'])
            ->where('nik_catin1', $nik)
            ->orWhere('nik_catin2', $nik)
            ->firstOrFail();

        // Tambahkan blok ini DI SINI
        $catin_wanita = null;
        $catin_pria = null;

        if ($catin->catin1 && $catin->catin1->jenis_kelamin === 'Perempuan') {
            $catin_wanita = $catin->catin1;
        } elseif ($catin->catin2 && $catin->catin2->jenis_kelamin === 'Perempuan') {
            $catin_wanita = $catin->catin2;
        }

        if ($catin->catin1 && $catin->catin1->jenis_kelamin === 'Laki-laki') {
            $catin_pria = $catin->catin1;
        } elseif ($catin->catin2 && $catin->catin2->jenis_kelamin === 'Laki-laki') {
            $catin_pria = $catin->catin2;
        }

        // Jika perlu usia, tambahkan ini juga (opsional)
        $usia_wanita = $catin_wanita ? Carbon::parse($catin_wanita->tanggal_lahir)->age : null;
        $usia_pria = $catin_pria ? Carbon::parse($catin_pria->tanggal_lahir)->age : null;

        return Inertia::render('Catin/Show', [
            'catin' => [
                'tanggal_pernikahan' => $catin->tanggal_pernikahan,
                'tinggi_badan' => $catin->tinggi_badan,
                'berat_badan' => $catin->berat_badan,
                'indeks_massa_tubuh' => $catin->indeks_massa_tubuh,
                'kadar_hemoglobin' => $catin->kadar_hemoglobin,
                'LILA' => $catin->LILA,
                'menggunakan_alat_kontrasepsi' => $catin->menggunakan_alat_kontrasepsi,
                'catin_wanita_meerokok_terpapar' => $catin->catin_wanita_meerokok_terpapar,
                'catin_pria_meerokok_terpapar' => $catin->catin_pria_meerokok_terpapar,
                'sumber_air_minum' => $catin->sumber_air_minum,
                'fasilitas_BAB' => $catin->fasilitas_BAB,
                'catin_wanita' => $catin_wanita,
                'catin_pria' => $catin_pria,
                'usia_wanita' => $usia_wanita,
                'usia_pria' => $usia_pria,
            ],
        ]);
    }


}
